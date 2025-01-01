<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class EventController extends Controller
{
    use AuthorizesRequests; // Include this trait

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

            // Insert the event into the database
            $eventId = DB::table('events')->insertGetId([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'event_date' => $validated['event_date'],
                'location' => $validated['location'],
                'organizer_id' => Auth::user()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Log event creation
            Log::info('Event created successfully: ', ['event_id' => $eventId]);

            // Insert tickets for the event
            $ticketTypes = $validated['ticketType'];
            $ticketPrices = $validated['ticketPrice'];
            $ticketQuantities = $validated['ticketQuantity'];
            $totalTicketAvailability = 0;

            foreach ($ticketTypes as $index => $type) {
                DB::table('tickets')->insert([
                    'event_id' => $eventId,
                    'type' => $type,
                    'price' => $ticketPrices[$index],
                    'quantity' => $ticketQuantities[$index],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                 // Add to the total ticket availability
                $totalTicketAvailability += $ticketQuantities[$index];
                // Log ticket creation
                Log::info('Ticket created successfully for event: ', ['event_id' => $eventId, 'type' => $type]);
            }

             // Update the event's ticket availability
            DB::table('events')->where('id', $eventId)->update([
                'ticket_availability' => $totalTicketAvailability,
                'updated_at' => now(),
            ]);

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

    // View Event
    public function view($id)
    {
        // Fetch the event and its associated tickets
        $event = DB::table('events')->where('id', $id)->first();
        $tickets = DB::table('tickets')->where('event_id', $id)->get();

        // Check if the event exists
        if (!$event) {
            return redirect()->route('events.index')->withErrors('Event not found.');
        }

        return view('events.view', compact('event', 'tickets'));
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
            'event_date' => 'required|date|after_or_equal:today',
            'location' => 'required|string|max:255',
            'tickets' => 'required|array',
            'tickets.*.id' => 'nullable|exists:tickets,id',
            'tickets.*.type' => 'required|string|max:50',
            'tickets.*.price' => 'required|numeric|min:0',
            'tickets.*.quantity' => 'required|integer|min:1',
        ]);


        // Update event details
        $event->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'event_date' => $validated['event_date'],
            'location' => $validated['location'],
        ]);

        //dd($validated);
        $totalTicketAvailability = 0;
        
        // Process tickets
        foreach ($validated['tickets'] as $ticketData) {
             // Log ticket creation
             Log::info('Ticket for event: ', ['ticket_id' => $ticketData['id']]);
            if (isset($ticketData['id'])) {
                // Update existing ticket
                $ticket = Ticket::findOrFail($ticketData['id']);
                
                $ticket->update([
                    'type' => $ticketData['type'],
                    'price' => $ticketData['price'],
                    'quantity' => $ticketData['quantity'],
                ]);
                   // Add to the total ticket availability
                   $totalTicketAvailability += $ticketData['quantity'];
            } else {
                // Create new ticket
                Ticket::create([
                    'event_id' => $event->id,
                    'type' => $ticketData['type'],
                    'price' => $ticketData['price'],
                    'quantity' => $ticketData['quantity'],
                ]);

                 // Add to the total ticket availability
                 $totalTicketAvailability += $ticketData['quantity'];
            }
        }

         // Update the event's ticket availability
         DB::table('events')->where('id', $event->id)->update([
            'ticket_availability' => $totalTicketAvailability,
            'updated_at' => now(),
        ]);

        return redirect()->route('events.index')->with('success', 'Event updated successfully.');
    }


    // Cancel an event
    public function destroy(Event $event)
    {
        // Check if event exists
        if ($this->authorize('delete', $event)) {
            // Debugging
           
            // Authorization passed
            $event->delete();
            return redirect()->route('events.index')->with('success', 'Event canceled successfully.');
        } else {
            // Authorization failed
            return redirect()->route('events.index')->with('error', 'You are not authorized to delete this event.');
        }
    }
}
