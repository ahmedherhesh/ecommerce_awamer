@extends('master')
@section('content')

    @isset($details)
        <h1>{{$details['title']}}</h1>
        <p>{{$details['body']}}</p>
    @endisset

@endsection
