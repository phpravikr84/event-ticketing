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
        $event = Event::with('ticketTypes')->findOrFail($eventId);

        return view('events.book', compact('event'));
    }


}
