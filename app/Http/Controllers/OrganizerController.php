<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\Attendee;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class OrganizerController extends Controller
{
    private function getOrganizerEvents()
    {
        return Event::where('organizer_id', Auth::id())->get();
    }

    public function dashboard()
    {
        $events = $this->getOrganizerEvents()->load('tickets', 'payments');
        $totalTicketsSold = $events->sum(fn($event) => $event->tickets->count());
        $totalRevenue = $events->sum(fn($event) => $event->payments->sum('amount'));
        return view('organizer.dashboard', compact('events', 'totalTicketsSold', 'totalRevenue'));
    }

    public function manageEvents()
    {
        $events = Event::where('organizer_id', Auth::id())->paginate(10);
        return view('organizer.events', compact('events'));
    }

    public function showTicketSales()
    {
        // Get all events created by the authenticated organizer
        $events = Event::where('organizer_id', Auth::user()->id)->get();
    
        // Check if events exist
        if ($events->isEmpty()) {
            return redirect()->route('organizer.events')->with('error', 'No events found for this organizer.');
        }
    
        // Get all payment records related to these events
        $payments = Payment::whereIn('payments.event_id', $events->pluck('id'))  // Get payments for all events of the organizer
                           ->join('users', 'users.id', '=', 'payments.user_id')  // Join with users to get user name
                           ->join('tickets', 'tickets.id', '=', 'payments.ticket_id')  // Join with tickets to get ticket details
                           ->select('users.name as user_name', 'tickets.type as ticket_type', 'payments.booking_quantity', 'payments.amount', 'payments.status', 'payments.event_id')
                           ->get();
    
        // Group the payments by event_id
        $paymentsGrouped = $payments->groupBy('event_id');
    
        // Return the view with events and grouped payment data
        return view('organizer.ticket-sales', compact('events', 'paymentsGrouped'));
    }    



    public function attendees()
    {
        // Get all users who have role_id = 2 and are associated with any of the organizer's events
        $attendees = User::where('role_id', 2)->get();

        return view('organizer.attendees', compact('attendees'));
    }

    public function payments()
    {
        $events = $this->getOrganizerEvents()->load('payments');
        $payments = $events->flatMap->payments;
        return view('organizer.payments', compact('payments'));
    }

    public function reports()
    {
        $events = $this->getOrganizerEvents()->load('tickets', 'payments');
        $reportData = $events->map(function ($event) {
            return [
                'Event Title' => $event->title,
                'Tickets Sold' => $event->tickets->count(),
                'Revenue' => $event->payments->sum('amount'),
            ];
        });

        return view('organizer.reports', compact('reportData'));
    }
}
