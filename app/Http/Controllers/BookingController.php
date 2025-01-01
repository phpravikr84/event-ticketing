<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;

class BookingController extends Controller
{
    public function bookingDetails()
    {
        $userId = auth()->id();
        
        // Fetch all bookings and related event and ticket details for the logged-in user
        $bookings = Payment::with(['event', 'ticket'])
            ->where('user_id', $userId)
            ->get();

        return view('booking.details', compact('bookings'));
    }

}
