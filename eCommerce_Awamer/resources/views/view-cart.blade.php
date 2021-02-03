<?php
  use Illuminate\Support\Facades\DB;

  function getItem($table,$col,$item_id){
    $item = DB::table($table)->where($col,'=',$item_id);
    return $item;
  }

?>
@extends('master')
@section('title')
    <title>E-Commerce | Cart</title>
@endsection
@section('content')
  {{View::make('navbar')}}
    <div class="container top">
      @if(isset($allCart))        
        <div class="row">
          @foreach ($allCart as $cart)
            <div class="col-md-3 col-sm-6 col-xs-12 bottom">
              <div class="card box-shadow">
                  <img class="card-img-top" src="{{asset('uploads/images/'. getItem('items','id',$cart)->first()->image) }}" alt="Card image cap">
                  <div class="card-body">
                    <h5 class="card-title text-center">{{getItem('items','id',$cart)->first()->name}}</h5>
                    <p class="card-text">Price : {{getItem('items','id',$cart)->first()->price}}</p>
                    <p class="card-text"> count : {{array_count_values($countCart)[$cart]}}</p>
                    <a href="/view-item/{{$cart}}" class="btn btn-success btn-block confirm">confirm</a>
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