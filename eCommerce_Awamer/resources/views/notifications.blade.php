@extends('master')
@section('content')
    @isset($message)
        <div class="container top">
            <div class="alert alert-info">{{$message}}</div>
        </div>
    @endisset
@endsection
