<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\UserViewTrait;


class ProjectController extends Controller
{
    use UserViewTrait;
    /**
     * Retrieves the view for the project details.
     *
     * @return \Illuminate\Contracts\View\View the view for the project details
     */
    public function projectview()
    {
        $managers = $this->userdetails('manager');
        $members = $this->userdetails('member');
        $projects = Project::where('company_id',auth()->user()->company_id)
        ->with(['manager', 'member'])
        ->withTrashed()
        ->get();
        return view('projectsdetails.home',compact('members','managers','projects'));
    }
    /**
     * Retrieves the view for the project form.
     *
     * @param Project|null $project The project to be displayed in the form
     * @return \Illuminate\Contracts\View\View the view for the project form
     */
    public function projectform(Project $project = null)
    {
        $managers = $this->userdetails('manager');
        $members = $this->userdetails('member');
        return view('projectsdetails.projectform',compact('members','managers','project'));
    }
    /**
     * Save the project data.
     *
     * @param ProjectRequest $request The request object containing the project data
     * @throws Some_Exception_Class description of exception
     * @return \Illuminate\Http\RedirectResponse The redirect response to the project view
     */
    public function projectsave(ProjectRequest $request){
        $data = $request->validated();
        $project = Project::updateOrCreate(['id' => $request->id], $data);
        return response()->json($project);
    }
    /**
     * Deletes a project.
     *
     * @param Project|null $project The project to be deleted
     * @return \Illuminate\Http\RedirectResponse Redirects to the project view
     */
    public function projectdelete(Project $project){
        $project->delete();
        return response()->json();
    }
    /**
     * Restores a project.
     *
     * @param Project|null $project The project to be restored (optional)
     * @return \Illuminate\Http\RedirectResponse Redirects to the project view
     */
    public function projectrestore(Project $project){
        $project->restore();
        return response()->json();
    }
}
