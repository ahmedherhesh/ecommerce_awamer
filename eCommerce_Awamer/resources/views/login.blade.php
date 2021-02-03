@extends('master')
@section('title')
    <title>E-Commerce | Login</title>
@endsection
@section('content')
  {{View::make('navbar')}}
    <div class="container">
        <div class="row">
            <form action="{{route('login')}}" method="POST" class="col-md-4 offset-md-4 top">
                @csrf
                <div class="form-group">
                  <label for="exampleInputEmail1">Email address</label>
                  <input type="email" class="form-control" id="exampleInputEmail1" name="email" placeholder="Enter email">
                  @error('email')
                      <div class="text-danger">{{$message}}</div>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Password</label>
                  <input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="Password">
                  @error('password')
                      <div class="text-danger">{{$message}}</div>
                  @enderror
                </div>
                <div class="form-group">
                  <button type="submit" class="btn btn-outline-info">Login</button> 
                  <a href="{{route('register')}}" class="btn btn-outline-success " style="float:right">create account</a>
                </div>

                <div class="form-group">
                  @if(session()->has('note_for_email'))
                    <div class="alert alert-danger " style="">{{session()->get('note_for_email')}}</div>
                  @endif
                </div>

              </form>

        </div>
    </div>
@endsection