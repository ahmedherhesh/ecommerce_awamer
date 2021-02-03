@extends('master')
@section('title')
    <title>E-Commerce | Items</title>
@endsection
@section('content')
    {{View::make('navbar')}}
    <div class="text-right" >
        <a href="/add-item" style="margin-top:10px;margin-right:10px;" class="btn btn-outline-primary text-right">add</a>
    </div>
    <div class="container">
        @if(session()->has('warning'))
            <div class="alert alert-warning text-center bold">{{session()->get('warning')}}</div>
        @endif
        <div class="row">
            @if (!empty($items))
                @foreach ($items as $item)
                        <div class="col-md-3 col-sm-6 col-xs-12 bottom">
                                <div class="card box-shadow">
                                    <img class="card-img-top" src="{{asset('uploads/images/'.$item->image) }}" alt="Card image cap">
                                    <div class="card-body">
                                    <h5 class="card-title text-center">{{$item->name}}</h5>
                                    <p class="card-text">{{$item->description}}</p>
                                    <p class="card-text">Price : {{$item->price}}</p>
                                    <form action="{{route('addToCart')}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="item_id" value="{{$item->id}}">
                                        <button type="submit" class="btn btn-success" >Add To Cart</button>
                                    </form>
                                    </div>
                                </div>
                        </div>
                    @endforeach
            @else
                <div class="col-md-12">
                    <h1 class="text-center text-secondary" style="margin-top:200px;font-size:70px">empty</h1>
                </div>
            @endif
        </div>
    </div>
    
@endsection