@extends('master')
@section('title')
<title>E-Commerce | view</title>
@endsection
@section('content')
{{ View::make('navbar') }}
<div class="container top">
    @if(session()->has('success'))
        <div class="alert alert-success text-center">{{ session()->get('success') }}</div>
    @endif
    @if(session()->has('fail'))
        <div class="alert alert-danger text-center">{{ session()->get('fail') }}</div>
    @endif
    <div class="row">
        <div class="col-md-4">
            <form action="{{ route('insertOrder') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="address">address</label>
                    <input type="hidden" name="seller_id" value="{{ $item->user_id }}">
                    <input type="hidden" name="item_id" value="{{ $item->id }}">
                    <input class="form-control" type="text" name="address" id="address" placeholder="address">
                    @error('address')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group map" id="map">

                </div>
                <div class="form-group">
                    <label for="received-date">received date</label>
                    <input class="form-control" type="date" name="received_data" id="received-date">
                    @error('received_data')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <b>total price :</b>
                    {{ isset($_COOKIE['item_id']) && in_array($item->id,$_COOKIE['item_id']) ?   array_count_values($_COOKIE['item_id'])[$item->id] * $item->price : $item->price, }}
                    @if(isset($order))
                        <span class="btn btn-info btn-block">request status : {{ $order->status }}</span>
                    @else
                        <button class="btn btn-success btn-block">Buy</button>
                    @endif

                </div>
            </form>
        </div>
        <div class="col-md-8">
            <div class="card box-shadow">
                <img class="card-img-top" src="{{ asset('uploads/images/'.$item->image) }}"
                    alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title text-center">{{ $item->name }}</h5>
                    <p class="card-text">{{ $item->description }}</p>
                    <p class="card-text">Price : {{ $item->price }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
