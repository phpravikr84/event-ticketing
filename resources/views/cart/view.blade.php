@extends('layouts.front')

@section('title', 'Cart | Veefin')

@section('page-title')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Cart</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ URL::to('/') }}">Cart</a></li>
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
        <ul>
            @foreach(session('cart', []) as $item)
                <li>
                    Event: {{ $item['event_id'] }} | Ticket Type: {{ $item['ticket_type'] }} | Quantity: {{ $item['quantity'] }}
                </li>
            @endforeach
        </ul>
        <div class="form-check">
            <input type="radio" class="form-check-input" id="virtualPayment" name="payment_method" value="virtual" checked>
            <label class="form-check-label" for="virtualPayment">Virtual Payment</label>
        </div>
        <button type="submit" class="btn btn-primary">Checkout</button>
    </form>
</div>
@endsection
