@extends('layouts.front')

@section('title', 'Cart | Veefin')

@section('page-title')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Cart</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ URL::to('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Cart</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="container">
    <h2>Your Cart</h2>
    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf
        @if(session('event'))
            @php
                $event = session('event');
                $ticketTypes = $event->tickets;
            @endphp
            <div class="event-details card mb-4">
                <div class="card-body">
                    <h5 class="card-title">{{ $event->title }}</h5>
                    <p><strong>Location:</strong> {{ $event->location }}</p>
                    <p><strong>Event Date:</strong> {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}</p>
                    <p><strong>Description:</strong> {{ $event->description }}</p>

                    <h6>Available Tickets</h6>
                    @foreach($ticketTypes as $ticket)
                        <div class="ticket-details mb-3">
                            <h6 class="text-success"><strong>{{ $ticket->type }}</strong></h6>
                            <p>Price: ${{ $ticket->price }}</p>
                            <p>Available Quantity: {{ $ticket->quantity }}</p>
                            <label for="quantity_{{ $ticket->id }}">Quantity:</label>
                            <!-- Hidden input for ticket_id and quantity as part of a nested array -->
                        <input type="hidden" name="tickets[{{ $ticket->id }}][ticket_id]" value="{{ $ticket->id }}">
                        <input type="number" class="form-control" id="quantity_{{ $ticket->id }}" name="tickets[{{ $ticket->id }}][quantity]" min="1" max="{{ $ticket->quantity }}" value="1">
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <p>Your cart is empty.</p>
        @endif

        <div class="form-check">
            <input type="radio" class="form-check-input" id="virtualPayment" name="payment_method" value="virtual" checked>
            <label class="form-check-label" for="virtualPayment">Virtual Payment</label>
        </div>

        <!-- Checkout Button -->
        <button type="submit" class="btn btn-primary mt-3">Proceed to Checkout</button>
    </form>
</div>
@endsection
