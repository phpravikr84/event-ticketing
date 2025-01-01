<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Event;

class DashboardController extends Controller
{
    /**
     * Display the appropriate dashboard based on the user's role.
     */
    public function index()
    {
        $user = Auth::user();
        $userId = $user->id;
        // Determine the user's role and redirect to the appropriate dashboard
        switch ($user->role->name) {
            case 'admin':
                return view('administrator.dashboard.admin');
            
            case 'attendee':
                    // Total Events Booked
                    $totalEvents = Payment::where('user_id', $userId)
                    ->distinct('event_id')  // Count distinct events
                    ->count('event_id');

                    // Total Number of Tickets Booked
                    $totalTickets = Payment::where('user_id', $userId)
                        ->sum('booking_quantity');  // Sum of all ticket quantities

                    // Total Amount of Booking
                    $totalAmount = Payment::where('user_id', $userId)
                        ->sum('amount');  // Sum of all amounts
                return view('administrator.dashboard.attendee', compact('totalEvents', 'totalTickets', 'totalAmount'));
            
            case 'organizer':
                 // Total Events Booked by the specific organizer
                $totalEvents = Event::where('organizer_id', $userId)->count();

                // Get all event IDs where the authenticated user is the organizer
                $eventIds = Event::where('organizer_id', $userId)->pluck('id');

                // Total Number of Tickets Booked for all events organized by the user
                $totalTickets = Payment::whereIn('event_id', $eventIds)
                                    ->sum('booking_quantity'); // Sum of all booking quantities

                // Total Amount of Booking for all events organized by the user
                $totalAmount = Payment::whereIn('event_id', $eventIds)
                                    ->sum('amount'); // Sum of all booking amounts

                return view('administrator.dashboard.organizer', compact('totalEvents', 'totalTickets', 'totalAmount'));
            
            default:
                return redirect()->route('login')->with('error', 'Unauthorized access.');
        }
    }
}
