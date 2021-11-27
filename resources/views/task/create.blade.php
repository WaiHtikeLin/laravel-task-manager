@extends('layouts.master')

@section('content')

<h3>Add A Task To Project {{$project->name}}</h3>

<form action="/projects/{{$project->id}}/tasks" method="post">

  @csrf
  <label for="name">Name</label>
  <input type="text" name="name" id="name" value="{{old('name')}}">

  @error('name')
  <p style="color:red">{{$message}}</p>
  @enderror

  <input type="submit" name="" value="Add">
</form>

@endsection
