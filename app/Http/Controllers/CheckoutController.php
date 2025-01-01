<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Ticket;
use Illuminate\Support\Facades\Log;
class CheckoutController extends Controller
{
    //Checkout
    public function processCheckout(Request $request)
    {
        Log::info('ProcessCheckout: Started method.');

        try {
            $validated = $request->validate([
                'payment_method' => 'required|in:virtual',
                'tickets' => 'required|array|min:1',
            ], [
                'tickets.required' => 'At least one ticket must be selected.',
            ]);
            
            Log::info('ProcessCheckout: Validation passed.', ['validated' => $validated]);
        } catch (\Exception $e) {
            Log::error('ProcessCheckout: Validation failed.', ['error' => $e->getMessage()]);
            return redirect()->route('cart.view')->with('error', 'Validation failed.');
        }

        $cart = session('event');
        Log::info('ProcessCheckout: Retrieved cart session.', ['cart' => $cart]);

        if (empty($cart)) {
            Log::warning('ProcessCheckout: Cart is empty.');
            return redirect()->route('cart.view')->with('error', 'Your cart is empty.');
        }

        $totalAmount = 0;
        $paymentData = [];
        $totalBookingQuantity = 0;
        foreach ($validated['tickets'] as $ticketInfo) {
            Log::info('ProcessCheckout: Processing ticket.', ['ticketInfo' => $ticketInfo]);

            $ticket = Ticket::findOrFail($ticketInfo['ticket_id']);
            Log::info('ProcessCheckout: Found ticket.', ['ticket' => $ticket]);

            $quantity = $ticketInfo['quantity'];
            $amount = $ticket->price * $quantity;

            Log::info('ProcessCheckout: Calculated ticket amount.', [
                'quantity' => $quantity,
                'amount' => $amount,
            ]);

            $totalAmount += $amount;
            $totalBookingQuantity += $quantity;

            $paymentData[] = [
                'event_id' => $cart->id,
                'user_id' => auth()->id(),
                'ticket_id' => $ticket->id,
                'booking_quantity' => $quantity,
                'amount' => $amount,
                'status' => 'success',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Log::info('ProcessCheckout: Prepared payment data.', ['paymentData' => $paymentData]);

        $event = Event::findOrFail($cart->id);
        Log::info('ProcessCheckout: Found event.', ['event' => $event]);

        $event->ticket_availability -= $totalBookingQuantity;
        $event->save();
        Log::info('ProcessCheckout: Updated event ticket availability.', [
            'ticket_availability' => $event->ticket_availability,
        ]);

        $booking = Booking::create([
            'user_id' => auth()->id(),
            'details' => json_encode($validated['tickets']),
            'payment_method' => $validated['payment_method'],
            'status' => 1,
        ]);
        Log::info('ProcessCheckout: Created booking.', ['booking' => $booking]);

        Payment::insert($paymentData);
        Log::info('ProcessCheckout: Inserted payment records.');

        session()->forget('event');
        Log::info('ProcessCheckout: Cleared cart session.');

        Log::info('ProcessCheckout: Completed successfully.');
        return redirect()->route('booking.details')->with('success', 'Booking confirmed!');
    }


}
