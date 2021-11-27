@extends('layouts.master')

@section('content')

                    <h3>Projects</h3>

                    <a href="/projects/create">Add A Project</a>
                    <a href="/projects">Manage Projects</a>
                    <br>
                    <br>
                    <select onchange="showTasks(this)" id="projects">
                      <option value="">Select A Project</option>
                      @foreach($projects as $p)
                      <option value="{{$p->id}}">{{$p->name}}</option>
                      @endforeach
                    </select>


                    <h4>Tasks</h4>

                    @if(isset($tasks) && count($tasks))
                    <a href="/projects/{{$project->id}}/tasks/create">Add A Task</a>

                    <div>
                      <div style="height:50px" data-priority="0" ondrop="drop(event)" ondragover="allowDrop(event)">
                      </div>

                      @foreach($tasks as $task)
                        <div class="task-row" style="padding-top:20px; margin-top: 20px; max-width:300px;cursor:pointer" data-priority="{{$task->priority}}" id="task_{{$task->id}}" draggable="true" ondragstart="drag(event)" ondrop="drop(event)" ondragover="allowDrop(event)">
                        <span>{{$task->name}}</span>

                        <a href="/tasks/{{$task->id}}/edit" class="mx-2">[Edit]</a>

                        <a href="javascript:;" onclick="deleteTask({{$task->id}})">[Delete]</a>
                        </div>
                      @endforeach

                      <div style="padding-top:20px;height:100px" data-priority="-1" ondrop="drop(event)" ondragover="allowDrop(event)">
                      </div>

                    </div>
                    @endif

    <form action="" method="post" id="task_delete_form">
      @csrf
      @method('delete')
    </form>

    <script type="text/javascript">

      @if(isset($project))
      document.querySelector("#projects > option[value='{{$project->id}}']").selected = true;
      @endif

      function showTasks(s) {
        if(s.value)
          location.href = '/projects/'+s.value+'/tasks';
      }

      function deleteTask(id) {
        if(confirm('Are you sure?'))
        {
          var f = document.querySelector("#task_delete_form");
          f.action = '/tasks/'+id;
          f.submit();
        }
      }

      function allowDrop(ev) {
          ev.preventDefault();
}

function drag(ev) {
  if(ev.target.nodeName == 'DIV')
    ev.dataTransfer.setData("text", ev.target.id);
  else
    ev.preventDefault();
}

function drop(ev) {
  ev.preventDefault();
  if(ev.target.nodeName == 'DIV')
  {
    var data = ev.dataTransfer.getData("text");

    var task = document.getElementById(data);
    var task_priority = task.getAttribute('data-priority');
    console.log(task_priority);

    var target_priority = ev.target.getAttribute('data-priority');

    axios.patch('/tasks/priority', {
      task_priority: task_priority,
      target_priority: target_priority
    }).then(res => {
      if(res.data.target_priority == 0)
        ev.target.after(task);
      else
        ev.target.before(task);
    });
  }
}

    </script>
@endsection
