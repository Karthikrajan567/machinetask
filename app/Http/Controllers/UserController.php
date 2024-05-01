<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateuserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\UserCreate;
use App\Traits\UserViewTrait;


class UserController extends Controller
{
    use UserCreate, UserViewTrait;
    /**
     * Retrieves the list of team members and displays them in the team member home view.
     *
     * @param Request $request The HTTP request object containing the query parameters.
     * @return \Illuminate\Contracts\View\View The rendered team member home view.
     */
    public function userview(Request $request)
    {
        $members = User::query();
        $members = $this->getUserViewData($members, $request, 'member');
        return view('teammember.home',compact('members'));
    }
    public function userform(User $user = null)
    {
    /**
     * Retrieves the user form view with the specified user data.
     *
     * @param User|null $user The user object to be passed to the view (default: null)
     * @return \Illuminate\Contracts\View\View The user form view
     */
        return view('teammember.userform',compact('user'));
    }
    /**
     * Deletes a user.
     *
     * @param User|null $user The user to be deleted (optional)
     * @return \Illuminate\Http\RedirectResponse Redirects to the user view
     */
    public function userdelete(User $user = null){
        $user->delete();
        return redirect()->route('userview');
    }
    /**
     * Restores a user.
     *
     * @param User|null $user The user to be restored (optional)
     * @return \Illuminate\Http\RedirectResponse Redirects to the team member home view
     */
    public function userrestore(User $user = null){
        $user->restore();
        return redirect()->route('userview');
    }
    /**
     * Saves user data from the request, creates a new user, and redirects to the user view.
     *
     * @param CreateuserRequest $request The request object containing the user data
     * @return \Illuminate\Http\RedirectResponse Redirects to the user view
     */
    public function usersave(CreateuserRequest $request){
        $data = $request->validated();
        $user = $this->createUser($data, 'member');
        return redirect()->route('userview');
     }
}
