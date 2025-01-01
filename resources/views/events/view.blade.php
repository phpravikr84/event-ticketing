@extends('layouts.app')

@section('title', 'Events | Veefin')

@section('page-title')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Event Details</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Event Details - Organizer</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="container">
    <div class="card mb-3">
        <div class="card-header bg-primary text-white">
            <h4>Event Details</h4>
        </div>
        <div class="card-body">
            <p><strong>Title:</strong> {{ $event->title }}</p>
            <p><strong>Description:</strong> {{ $event->description }}</p>
            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}</p>
            <p><strong>Location:</strong> {{ $event->location }}</p>
            <p><strong>Ticket Availability:</strong> {{ $event->ticket_availability }}</p>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-secondary text-white">
            <h4>Tickets</h4>
        </div>
        <div class="card-body">
            @if ($tickets->isEmpty())
                <p>No tickets available for this event.</p>
            @else
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Type</th>
                            <th>Price</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tickets as $index => $ticket)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $ticket->type }}</td>
                                <td>${{ number_format($ticket->price, 2) }}</td>
                                <td>{{ $ticket->quantity }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection