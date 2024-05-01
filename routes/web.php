<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Member\HomeController as MemberHomeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;

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

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::middleware(['checkPermissions:create task'])->group(function () {
    // Routes that require the "create task" permission for any role
});
Route::middleware(['checkPermissions:create user'])->group(function () {
    Route::get('/userview', [UserController::class, 'userview'])->name('userview');
    Route::get('/userform/{user?}', [UserController::class, 'userform'])->name('userform');
    Route::post('/usersave', [UserController::class, 'usersave'])->name('usersave');
    Route::get('/userdelete/{user}', [UserController::class, 'userdelete'])->name('userdelete');
    Route::get('/userrestore/{user}', [UserController::class, 'userrestore'])->name('userrestore');
});

Route::middleware(['checkPermissions:create project'])->group(function () {
    Route::get('/projectview', [ProjectController::class, 'projectview'])->name('projectview');
    Route::get('/projectform/{project?}', [ProjectController::class, 'projectform'])->name('projectform');
    Route::post('/projectsave', [ProjectController::class, 'projectsave'])->name('projectsave');
    Route::get('/projectdelete/{project}', [ProjectController::class, 'projectdelete'])->name('projectdelete');
    Route::get('/projectrestore/{project}', [ProjectController::class, 'projectrestore'])->name('projectrestore');

    Route::get('/taskview', [TaskController::class, 'taskview'])->name('taskview');
    Route::get('/taskform/{task?}', [TaskController::class, 'taskform'])->name('taskform');
    Route::post('/tasksave', [TaskController::class, 'tasksave'])->name('tasksave');
    Route::get('/taskdelete/{task}', [TaskController::class, 'taskdelete'])->name('taskdelete');
});

