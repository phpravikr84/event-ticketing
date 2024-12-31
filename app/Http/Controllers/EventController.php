<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Facades\Log;


class EventController extends Controller
{
    // Display a list of events
    public function index()
    {
        $events = Event::where('organizer_id', Auth::id())->paginate(10);
        return view('events.index', compact('events'));
    }

    // Show form to create a new event
    public function create()
    {
        return view('events.create');
    }

    //Store Event
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'required|date',
            'location' => 'required|string|max:255',
            'ticketType' => 'required|array|min:1',
            'ticketPrice' => 'required|array|size:' . count($request->input('ticketType')),
            'ticketQuantity' => 'required|array|size:' . count($request->input('ticketType')),
        ]);

        try {
            // Start a transaction
            DB::beginTransaction();

            // Create the event
            $event = Event::create([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'event_date' => $validated['event_date'],
                'location' => $validated['location'],
                'organizer_id' => Auth::user()->id,
            ]);

            // Log event creation
            Log::info('Event created successfully: ', ['event_id' => $event->id]);

            // Create tickets for the event
            $ticketTypes = $validated['ticketType'];
            $ticketPrices = $validated['ticketPrice'];
            $ticketQuantities = $validated['ticketQuantity'];

            foreach ($ticketTypes as $index => $type) {
                // Create each ticket type for the event
                $ticket = Ticket::create([
                    'event_id' => $event->id,
                    'type' => $type,
                    'price' => $ticketPrices[$index],
                    'quantity' => $ticketQuantities[$index],
                ]);

                // Log ticket creation
                Log::info('Ticket created successfully: ', ['ticket_id' => $ticket->id]);
            }

            // Commit the transaction
            DB::commit();

            // Redirect back with a success message
            return redirect()->route('events.index')->with('success', 'Event created successfully.');
            
        } catch (\Exception $e) {
            // Rollback transaction if anything fails
            DB::rollBack();
            
            // Log the error for debugging purposes
            Log::error('Event creation failed: ', [
                'error_message' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString()
            ]);

            // Return with error message
            return redirect()->back()->withErrors('An error occurred while creating the event. Please try again.');
        }
    }



    // Show the form to edit an event
    public function edit(Event $event)
    {
        $this->authorize('update', $event); // Ensure only the organizer can edit
        return view('events.edit', compact('event'));
    }

    // Update an event
    public function update(Request $request, Event $event)
    {
        $this->authorize('update', $event);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date|after_or_equal:today',
            'location' => 'required|string|max:255',
            'tickets' => 'required|array',
            'tickets.*.id' => 'sometimes|exists:tickets,id',
            'tickets.*.type' => 'required|string|max:50',
            'tickets.*.price' => 'required|numeric|min:0',
            'tickets.*.quantity' => 'required|integer|min:1',
        ]);

        $event->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'date' => $validated['date'],
            'location' => $validated['location'],
        ]);

        foreach ($validated['tickets'] as $ticketData) {
            if (isset($ticketData['id'])) {
                $ticket = Ticket::find($ticketData['id']);
                $ticket->update($ticketData);
            } else {
                Ticket::create([
                    'event_id' => $event->id,
                    'type' => $ticketData['type'],
                    'price' => $ticketData['price'],
                    'quantity' => $ticketData['quantity'],
                ]);
            }
        }

        return redirect()->route('events.index')->with('success', 'Event updated successfully.');
    }

    // Cancel an event
    public function destroy(Event $event)
    {
        $this->authorize('delete', $event);
        $event->delete();
        return redirect()->route('events.index')->with('success', 'Event canceled successfully.');
    }
}
