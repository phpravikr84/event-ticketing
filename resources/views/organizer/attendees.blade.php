@extends('layouts.app')

@section('title', 'Ticket Sales')
@section('page-title')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Attendees</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ URL::to('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Attendees</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="container">
    <h2 class="mb-4">Attendees</h2>

    @if($attendees->isEmpty())
        <p>No attendees with the specified role found.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                </tr>
            </thead>
            <tbody>
                @foreach($attendees as $attendee)
                    <tr>
                        <td>{{ $attendee->name }}</td>
                        <td>{{ $attendee->email }}</td>
                        <td>{{ $attendee->role->name }}</td> <!-- Assuming you have a relationship to get the role name -->
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
