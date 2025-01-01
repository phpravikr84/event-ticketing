@extends('layouts.app')

@section('title', 'Events | Edit Event')

@section('page-title')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Edit Event</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Edit Event</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<form action="{{ route('events.update', $event->id) }}" method="POST" id="eventForm">
        @csrf
        @method('PUT')
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="mb-3">
            <label for="title" class="form-label">Event Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $event->title) }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="5" required>{{ old('description', $event->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="event_date" class="form-label">Date</label>
            <input type="date" class="form-control" id="event_date" name="event_date" 
                value="{{ old('event_date', $event->event_date ? $event->event_date->format('Y-m-d') : '') }}" 
                required>
        </div>

        <div class="mb-3">
            <label for="location" class="form-label">Location</label>
            <input type="text" class="form-control" id="location" name="location" value="{{ old('location', $event->location) }}" required>
        </div>

        <h4>Tickets</h4>
        <div id="ticketContainer">
            @foreach ($event->tickets as $ticket)
                <div class="ticket-row mb-3">
                    <div class="row">
                        <input type="hidden" name="tickets[{{ $loop->index }}][id]" value="{{ $ticket->id }}">
                        <div class="col-md-4">
                            <label for="ticketType[]" class="form-label">Ticket Type</label>
                            <select class="form-control" name="tickets[{{ $loop->index }}][type]" disabled="true" required >
                                <option value="Early Bird" {{ $ticket->type == 'Early Bird' ? 'selected' : '' }}>Early Bird</option>
                                <option value="Regular" {{ $ticket->type == 'Regular' ? 'selected' : '' }}>Regular</option>
                                <option value="VIP" {{ $ticket->type == 'VIP' ? 'selected' : '' }}>VIP</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="ticketPrice[]" class="form-label">Price</label>
                            <input type="number" class="form-control" name="tickets[{{ $loop->index }}][price]" value="{{ $ticket->price }}" min="0" required>
                        </div>
                        <div class="col-md-4">
                            <label for="ticketQuantity[]" class="form-label">Quantity</label>
                            <input type="number" class="form-control" name="tickets[{{ $loop->index }}][quantity]" value="{{ $ticket->quantity }}" min="0" required>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <!-- <div class="mb-3">
            <button type="button" id="addTicketButton" class="btn btn-secondary mb-3">Add Ticket</button>
        </div> -->
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Update Event</button>
        </div>
    </form>
@endsection
