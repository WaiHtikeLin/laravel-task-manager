<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectTaskController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth'])->group(function(){
  Route::get('/', [AppController::class, 'index'])->name('dashboard');
  Route::resource('projects', ProjectController::class)->except('show');
  Route::patch('/tasks/priority', [ProjectTaskController::class, 'changePriority']);
  Route::resource('projects.tasks', ProjectTaskController::class)->except('show')->shallow();
});

require __DIR__.'/auth.php';
