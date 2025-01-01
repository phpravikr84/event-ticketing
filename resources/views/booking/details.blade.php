@extends('layouts.app')

@section('title', 'Booking Detail | Veefin')

@section('page-title')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Booking Detail</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Booking Detail</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="container">
    <h2>Booking Details</h2>
    <p><strong>Event:</strong> {{ $booking->event->title }}</p>
    <p><strong>Tickets:</strong></p>
    <ul>
        @foreach(json_decode($booking->details, true) as $ticket)
            <li>Type: {{ $ticket['ticket_type'] }} | Quantity: {{ $ticket['quantity'] }}</li>
        @endforeach
    </ul>
    <p><strong>Payment Method:</strong> {{ ucfirst($booking->payment_method) }}</p>
</div>
@endsection
