@extends('layouts.app')

@section('title', 'Ticket Sales')
@section('page-title')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Ticket Sales</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ URL::to('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Ticket Sales</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection


@section('content')
<div class="container">
<h2>Your Events Ticket Sales</h2>

@foreach($events as $event)
    <h4 class="mb-sm-0">Ticket Sales for {{ $event->title }}</h4>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5>Ticket Sales Details for {{ $event->title }}</h5>
                    @php
                        $paymentsForEvent = $paymentsGrouped->get($event->id, []);
                    @endphp

                    @if(empty($paymentsForEvent))
                        <p>No ticket sales for this event.</p>
                    @else
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>User Name</th>
                                    <th>Ticket Type</th>
                                    <th>Booking Quantity</th>
                                    <th>Amount Paid</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($paymentsForEvent as $payment)
                                    <tr>
                                        <td>{{ $payment->user_name }}</td>
                                        <td>{{ $payment->ticket_type }}</td>
                                        <td>{{ $payment->booking_quantity }}</td>
                                        <td>${{ number_format($payment->amount, 2) }}</td>
                                        <td>{{ ucfirst($payment->status) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endforeach

</div>
@endsection