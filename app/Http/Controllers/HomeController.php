<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $events = Event::where('event_date', '>=', Carbon::today())->get();
        return view('home', compact('events'));
    }

    public function bookNow($eventId)
    {
        $event = Event::with('tickets')->findOrFail($eventId);

        // Check if the user is logged in
        if (!auth()->check()) {
            return redirect()->route('cart.view')->with('event', $event);
        }

        // Check if the logged-in user is an attendee
        if (auth()->user()->role_id !== 2) {
            return redirect()->route('login', ['role' => 'attendee'])
                            ->with('error', 'You need to be an attendee to book this event.');
        }

        // Add event details to the session cart
        session()->push('cart', [
            'event_id' => $event->id,
            'event_title' => $event->title,
            'ticket_type' => null, // Placeholder until the user selects
            'quantity' => null,    // Placeholder until the user selects
        ]);

        return redirect()->route('cart.view');
    }

}
