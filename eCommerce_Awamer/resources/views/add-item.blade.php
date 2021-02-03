@extends('master')
@section('title')
    <title>E-Commerce | Add-Item</title>
@endsection
@section('content')
    {{View::make('navbar')}}
    <div class="container top col-md-4 offset-md-4 text-center">
        <form action="{{route('add_item')}}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(session()->has('success'))
                <div class="alert alert-success">{{session()->get('success')}}</div>
            @endif
            <div class="form-group">
                <input  class="form-control" type="text" name="name" id="name" placeholder="Item Name">
                @error('name')
                    <div class="text-danger">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group">
                <input  class="form-control" type="number" name="price" id="name" placeholder="Item Name">
                @error('price')
                    <div class="text-danger">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group">
                <textarea  class="form-control" name="description" id="description" placeholder="Description"></textarea>
                @error('description')
                    <div class="text-danger">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group">
                <select class="custom-select" name="categories">
                    <option selected>Categories</option>
                    @foreach ($categories as $cat)
                        <option value="{{$cat->id}}">{{$cat->name}}</option>
                    @endforeach
                </select>
                @error('categories')
                    <div class="text-danger">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group">
                <select class="custom-select" name="status">
                    <option value="" selected>Status</option>
                    <option value="new">New</option>
                    <option value="used">Used</option>
                </select>
                @error('status')
                    <div class="text-danger">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group">
                <div class="custom-file text-left">
                    <input type="file" name="image" class="custom-file-input" >
                    <label class="custom-file-label" for="inputGroupFile03">Choose image</label>
                  </div>
                  @error('image')
                    <div class="text-danger">{{$message}}</div>
                  @enderror
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success">Add</button>
            </div>
        </form>
    </div>
@endsection