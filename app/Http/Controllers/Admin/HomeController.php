<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateuserRequest;
use App\Http\Requests\ManagerRequest;
use App\Models\User;
use App\Traits\UserCreate;
use App\Traits\UserViewTrait;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    use UserCreate, UserViewTrait;
    /**
     * Display the home page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(){

        return view('home');
    }
    /**
     * Renders the manager view based on the user data.
     *
     * @param Request $request The request object
     * @return \Illuminate\Contracts\View\View The manager view
     */
    public function managerview(Request $request){
        $managers = User::query();
        $managers = $this->getUserViewData($managers, $request, 'manager');
        return view('manager.home', compact('managers'));
    }
    /**
     * Renders the manager form view.
     *
     * @param User|null $user The user model (optional)
     * @return \Illuminate\View\View The manager form view
     */
    public function managerform(User $user = null){
        return view('manager.managerform',compact('user'));
    }
    /**
     * Deletes a manager user.
     *
     * @param User|null $user The user to be deleted
     * @return \Illuminate\Http\RedirectResponse Redirects to the manager view
     */
    public function managerdelete(User $user = null){
        $user->delete();
        return redirect()->route('admin.managerview');
    }
    /**
     * Restores a manager user.
     *
     * @param User|null $user The user to be restored (optional)
     * @return \Illuminate\Http\RedirectResponse Redirects to the manager view
     */
    public function managerrestore(User $user = null){
        $user->restore();
        return redirect()->route('admin.managerview');
    }
    /**
     * Saves a manager user.
     *
     * @param CreateuserRequest $request The request object containing the validated data for creating a manager user.
     * @return \Illuminate\Http\RedirectResponse Redirects to the manager view.
     */
    public function managersave(CreateuserRequest $request){
       $data = $request->validated();
        $user = $this->createUser($data, 'manager');
       return redirect()->route('admin.managerview');
    }
}
