@extends('master')
@section('title')
    <title>E-Commerce | Orders</title>
@endsection
@section('content')
  {{View::make('navbar')}}
    <div class="container top">
      @if(isset($getOrders))        
        <div class="row">
            @foreach ($getOrders as $order)
                <div class="col-md-3">
                    <div class="card box-shadow">
                        {{-- <img class="card-img-top" src="{{ asset('uploads/images/'.getItem('items',$order->item_id)->image) }}"
                            alt="Card image cap"> --}}
                        <div class="card-body">
                            <h5 class="card-title text-center">{{$getItem('items',$order->item_id)->name}}</h5>
                            <p class="card-text">name : {{$getItem('users',$order->customer_id)->username}}</p>
                            <p class="card-text">address : {{$order->address}}</p>
                            <p class="card-text">mobile : {{$order->mobile_number}}</p>
                            <p class="card-text">count : {{$order->count}}</p>
                            <p class="card-text">Price : {{$getItem('items',$order->item_id)->price * $order->count}}</p>
                            <form action="{{route('updateOrder')}}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <input type="hidden" name="customer_id" value="{{$order->customer_id}}">
                                    <input type="hidden" name="item_id" value="{{$order->item_id}}">
                                    <select name="status" class="custom-select">
                                        <option value="">Status</option>
                                        <option @if ($order->status == 'new') selected @endif value="new">New</option>
                                        <option @if ($order->status == 'working on it') selected @endif value="working on it">Working on it</option>
                                        <option @if ($order->status == 'finished') selected @endif value="finished">Finished</option>
                                    </select>
                                </div>
                                <button class="btn btn-secondary btn-block" type="submit">Save</button>
                            </form>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
      @else
          <h1 class="text-center text-secondary" style="margin-top:200px;font-size:70px">empty</h1>
      @endif
    </div>
@endsection