@extends('layouts.app')

@section('title', 'Events | Veefin')

@section('page-title')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Event Management</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Event Management - Organizer</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <a href="{{ route('events.create') }}" class="btn btn-primary">Create New Event</a>

    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Date</th>
                <th>Location</th>
                <th>Ticket Availability</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($events as $event)
                <tr>
                    <td>{{ $event->title }}</td>
                    <td>{{ $event->event_date }}</td>
                    <td>{{ $event->location }}</td>
                    <td>{{ $event->ticket_availability }}</td>
                    <td>
                        <a href="{{ route('events.edit', $event) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('events.destroy', $event) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" onclick="return confirm('Are you sure?')">Cancel</button>
                        </form>
                        <a href="{{ route('events.view', $event) }}" class="btn btn-primary">View</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $events->links() }}
@endsection
