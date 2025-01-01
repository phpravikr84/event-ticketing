<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function processCheckout(Request $request)
    {
        $validated = $request->validate([
            'payment_method' => 'required|in:virtual',
        ]);

        // Create a booking record
        $booking = Booking::create([
            'user_id' => auth()->id(),
            'details' => json_encode(session('cart')),
            'payment_method' => $validated['payment_method'],
            'status' => 'confirmed',
        ]);

        // Clear the cart
        session()->forget('cart');

        return redirect()->route('booking.details', $booking->id)->with('success', 'Booking confirmed!');
    }
}
