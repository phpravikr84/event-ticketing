@extends('layouts.front')

@section('title', 'Home | Veefin')

@section('page-title')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Home</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    @if(auth()->user() && auth()->user()->role_id==2)
                        <li class="breadcrumb-item"><a href="{{ route('administrator.dashboard.attendee') }}">Dashboard</a></li>
                    @endif
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')

<div class="row">
    @foreach($events as $event)
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm">
            <img src="{{ asset('assets/static/image.jpg') }}" class="card-img-top" alt="Event Image">
            <div class="card-body">
                <h5 class="card-title">{{ $event->title }}</h5>
                <p class="card-text"><strong>Location:</strong> {{ $event->location }}</p>
                <p class="card-text"><strong>Date:</strong> {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}</p>
            </div>
            <div class="card-footer text-center">
                @if($event->event_date < now())
                    <button class="btn btn-secondary" disabled>Event Ended</button>
                @elseif($event->attendees->count() < $event->ticket_availability)
                    <a href="{{ route('events.book', $event->id) }}" class="btn btn-primary">Book Now</a>
                @else
                    <button class="btn btn-secondary" disabled>Sold Out</button>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
