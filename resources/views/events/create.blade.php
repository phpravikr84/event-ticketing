@extends('layouts.app')

@section('title', 'Events | Veefin')

@section('page-title')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Create Event</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Create Event</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<form action="{{ route('events.store') }}" method="POST" id="eventForm">
        @csrf
        @if($errors->any())
            @foreach ($errors->all() as $error)
            <div class="alert alert-danger">{{ $error }}</div>                    
                {{ $error }}
            </div>
            @endforeach
        @endif

        <div class="mb-3">
            <label for="title" class="form-label">Event Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
        </div>

        <div class="mb-3">
            <label for="event_date" class="form-label">Date</label>
            <input type="date" class="form-control" id="event_date" name="event_date" required>
        </div>

        <div class="mb-3">
            <label for="location" class="form-label">Location</label>
            <input type="text" class="form-control" id="location" name="location" required>
        </div>

        <h4>Ticket Types</h4>
        <div id="ticketContainer">
            <div class="ticket-row mb-3">
                <div class="row">
                    <div class="col-md-4">
                        <label for="ticketType[]" class="form-label">Ticket Type</label>
                        <select class="form-control" name="ticketType[]" required>
                            <option value="Early Bird">Early Bird</option>
                            <option value="Regular">Regular</option>
                            <option value="VIP">VIP</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="ticketPrice[]" class="form-label">Price</label>
                        <input type="number" class="form-control" name="ticketPrice[]" min="0" required>
                    </div>
                    <div class="col-md-4">
                        <label for="ticketQuantity[]" class="form-label">Quantity</label>
                        <input type="number" class="form-control" name="ticketQuantity[]" min="0" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <button type="button" id="addTicketButton" class="btn btn-secondary mb-3">Add Ticket</button>
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Create Event</button>
        </div>
    </form>
@endsection