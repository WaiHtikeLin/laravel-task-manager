@extends('layouts.master')

@section('content')

<form action="/projects/{{$project->id}}" method="post">
  @csrf
  @method('patch')

  <label for="name">Name</label>

  <input type="text" name="name" id="name" value="{{$project->name}}">

  @error('name')
  <p style="color:red">{{$message}}</p>
  @enderror

  <input type="submit" name="" value="Update">
</form>

@endsection
