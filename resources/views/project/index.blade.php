@extends('layouts.master')

@section('content')

<a href="/projects/create">Add A Project</a>

<br>

<h3>Projects</h3>

<ul>
  @foreach($projects as $project)
  <li>
    <a href="/projects/{{$project->id}}/tasks">{{$project->name}}</a>
    <a href="/projects/{{$project->id}}/edit">[Edit]</a>
    <a href="javascript:;" onclick="deleteProject({{$project->id}})">
      [Delete]
    </a>
  </li>
  @endforeach
</ul>

<form method="post" id="project_delete_form">
    @csrf
    @method('delete')
</form>

<script type="text/javascript">
  function deleteProject(id) {
    if(confirm('Are you sure?'))
    {
      var f = document.querySelector("#project_delete_form");
      f.action = '/projects/'+id;
      f.submit();
    }
  }
</script>
@endsection
