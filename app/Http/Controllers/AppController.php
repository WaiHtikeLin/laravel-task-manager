<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class AppController extends Controller
{
  public function index()
  {
    return view('task.index', ['projects' => Project::all()]);
  }
}
