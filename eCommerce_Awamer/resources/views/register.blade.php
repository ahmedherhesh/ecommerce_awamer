@extends('master')
@section('title')
<title>E-Commerce | Register</title>
@endsection
@section('content')
{{View::make('navbar')}}
<div class="container">
    <div class="row">

        <form action="{{ route('register') }}" method="POST" class="col-md-4 offset-md-4 top ">
            @csrf
            @if(session()->has('success'))
                <div class="form-group">
                    <div class="alert alert-success">{{ session()->get('success') }}</div>
                </div>
            @endif
            <div class="form-group">
                <input type="text" class="form-control" name="username" placeholder="username">
                @error('username')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <input type="number" class="form-control" name="personal_mobile" placeholder="your mobile">
                @error('personal_mobile')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="email">
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="password">
                @error('password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="repeat_password" placeholder="repeat-password">
                @error('repeat_password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <input type="radio" name="role" value="customer" id="customer" checked>
                <label for="customer">customer</label>

                <input type="radio" style="margin-left:30px" name="role" value="seller" id="seller"
                    placeholder="repeat-password">
                <label for="seller">seller</label>
                @error('role')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group text-center">
                <button type="submit" class="btn btn-success text-center">create account</button>
            </div>
            @if(session()->has('email_exist'))
                <div class="form-group">
                    <div class="alert alert-danger">{{ session()->get('email_exist') }}</div>
                </div>
            @endif
        </form>

    </div>
</div>
@endsection
