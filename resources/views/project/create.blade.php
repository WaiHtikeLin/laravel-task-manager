@extends('layouts.master')

@section('content')

<form action="/projects" method="post">
  @csrf

  <label for="name">Name</label>

  <input type="text" name="name" id="name" value="{{old('name')}}" autofocus>

  @error('name')
  <p style="color:red">{{$message}}</p>
  @enderror

  <input type="submit" name="" value="Create">
</form>

@endsection
