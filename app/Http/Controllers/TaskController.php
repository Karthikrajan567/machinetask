<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Traits\UserViewTrait;

class TaskController extends Controller
{
    use UserViewTrait;
    /**
     * Retrieves the task view for the user.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function taskview(Request $request)
    {
        $members = $this->userdetails('member');
        $tasks = Task::where('company_id',auth()->user()->company_id)
        ->with('member');
        // Filter by name if a search query is provided
        if ($request->filled('search')) {
            $searchTerm = '%' . $request->input('search') . '%';
            $tasks->where(function ($query) use ($searchTerm) {
                $query->where('task_name', 'like', $searchTerm)
                    ->orWhere('task_description', 'like', $searchTerm)
                    ->orWhere('task_end_date', 'like', $searchTerm)
                    ->orWhere('task_member', 'like', $searchTerm)
                    ->orWhere('task_status', 'like', $searchTerm);
            });
        }
        $tasks = $tasks->paginate(10);
        return view('tasks.home',compact('members','tasks'));
    }
    /**
     * Generate the function comment for the given function body in a markdown code block with the correct language syntax.
     *
     * @param Task|null $task The task object (optional)
     * @return void
     */
    public function taskform(Task $task = null){
        $members = $this->userdetails('member');
        return view('tasks.taskform',compact('task','members'));
    }
    /**
     * Saves a task.
     *
     * @param TaskRequest $request The request object containing the validated data for creating or updating a task.
     * @return \Illuminate\Http\RedirectResponse Redirects to the task view.
     */
    public function tasksave(TaskRequest $request){
        $data = $request->validated();
        $project = Task::updateOrCreate(['id' => $request->id], $data);
        return redirect()->route('taskview');
    }
    /**
     * Deletes a task permanently and redirects to the task view.
     *
     * @param Task $task The task object to be deleted.
     * @return \Illuminate\Http\RedirectResponse Redirects to the task view.
     */
    public function taskdelete(Task $task){
        $task->forceDelete();
        return redirect()->route('taskview');
    }
}
