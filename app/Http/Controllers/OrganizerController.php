<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\Attendee;
use App\Models\Payment;
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

    public function ticketSales()
    {
        $events = $this->getOrganizerEvents()->load('tickets');
        $tickets = $events->flatMap->tickets;
        return view('organizer.ticket_sales', compact('tickets'));
    }

    public function attendees()
    {
        $events = $this->getOrganizerEvents()->load('attendees');
        $attendees = $events->flatMap->attendees;
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
