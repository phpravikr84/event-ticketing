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
    <h1>Booking Details</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered" id="bookingsTable">
        <thead>
            <tr>
                <th>Event</th>
                <th>Ticket</th>
                <th>Quantity</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Booking Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $booking)
            <tr>
                <td>{{ $booking->event->title }}</td>
                <td>{{ $booking->ticket->type }}</td>
                <td>{{ $booking->booking_quantity }}</td>
                <td>{{ $booking->amount }}</td>
                <td>{{ ucfirst($booking->status) }}</td>
                <td>{{ $booking->created_at->format('Y-m-d H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('#bookingsTable').DataTable();
    });
</script>
@endpush