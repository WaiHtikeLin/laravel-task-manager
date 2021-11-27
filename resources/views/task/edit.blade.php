@extends('layouts.master')

@section('content')

<form class="" action="/tasks/{{$task->id}}" method="post">
  @csrf
  @method('patch')

  <label for="projects">Project</label>
  <select class="" name="project_id" id="projects">
    @foreach($projects as $p)
    <option value="{{$p->id}}">{{$p->name}}</option>
    @endforeach
  </select>

  <br>

  <label for="name">Name</label>

  <input type="text" id="name" name="name" value="{{$task->name}}">

  @error('name')
  <p style="color:red">{{$message}}</p>
  @enderror

  <input type="submit" name="" value="Update">
</form>

<script type="text/javascript">
  document.querySelector("#projects > option[value='{{$task->project_id}}']").selected = true;
</script>
