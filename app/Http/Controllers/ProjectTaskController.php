<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Project;
use Illuminate\Validation\Rule;

class ProjectTaskController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Project $project)
    {
      $tasks = $project->tasks()->orderBy('priority')->get();
      $projects = Project::all();

      return view('task.index', ['project' => $project, 'tasks' => $tasks, 'projects' => $projects]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Project $project)
    {
      return view('task.create', ['project' => $project]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Project $project)
    {
      $project_id = $project->id;

      $data = $request->validate([
        'name' => ['bail', 'required', 'string', 'max:255', Rule::unique('tasks')->where(function ($query) use ($project_id) {
    return $query->where('project_id', $project_id);
})]]);

      $max_priority = Task::where('project_id', $project_id)->max('priority');
      $max_priority = $max_priority ??  0;

      $project->tasks()->create([
        'name' => $data['name'],
        'priority' => $max_priority+1
      ]);

      return redirect('/projects/'.$project->id.'/tasks');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
      //To change the project
      $projects = Project::all();

      return view('task.edit', ['projects' => $projects, 'task' => $task]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
      $project_id = $request->project_id;

      $data = $request->validate([
        'name' => ['bail', 'required', 'string', 'max:255', Rule::unique('tasks')->ignore($task)->where(function ($query) use ($project_id) {
    return $query->where('project_id', $project_id);
})],
        'project_id' => 'bail|required'
      ]);

      $task->update([
        'name' => $data['name'],
        'project_id' => $data['project_id']
      ]);

      return redirect('/projects/'.$data['project_id'].'/tasks');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
      $priority = $task->priority;
      $task->delete();
      Task::where('priority', '>', $priority)->decrement('priority');
      return redirect('/projects/'.$task->project_id.'/tasks');
    }

    public function changePriority(Request $request)
    {
      $priority = $request->task_priority;
      $target_priority = $request->target_priority;

      if($target_priority == -1)
      {
        $target_priority = Task::max('priority');
        $target_priority += 1;
      }

      $task = Task::where('priority', $priority)->first();

      if($priority > $target_priority)
      Task::where([
        ['priority', '>=', $target_priority],
        ['priority', '<', $priority]])->increment('priority');
      else {
      Task::where([
        ['priority', '>', $priority],
        ['priority', '<', $target_priority]])->decrement('priority');

        $target_priority -= 1;
      }

      $task->update([
        'priority' => $target_priority
      ]);

      return [ 'target_priority' => $target_priority ];
    }
}
