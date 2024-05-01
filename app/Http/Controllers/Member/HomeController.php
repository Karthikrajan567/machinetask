<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(){
        return view('home');
    }
    /**
     * Retrieves the task update view for the user.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function taskupdateview(){
        $user = User::where('uuid',auth()->user()->uuid)
        ->with('task')
        ->get();
        return view('tasks.taskupdate.home',compact('user'));
    }
    /**
     * Update the status of a task.
     *
     * @param Task $task The task to update.
     * @param Request $request The HTTP request containing the new status.
     * @return \Illuminate\Http\JsonResponse The updated task in JSON format.
     */
    public function updatestatus(Task $task,Request $request){
        $task->update(['task_status' => $request->status]);
        return response()->json(compact('task'));
    }
}
