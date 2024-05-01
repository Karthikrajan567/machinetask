<?php

namespace App\Traits;

use Spatie\Permission\Models\Role;

trait RedirectsUsers
{
    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectTo() : string
    {
        $role = auth()->user()->roles()->first()->name;
        $roles = Role::pluck('name')->toArray();
        $redirectUrl = "$this->redirectTo";
        if (in_array($role, $roles)) {
            $redirectUrl = "/$role$this->redirectTo";
        }

        return $redirectUrl;
    }
}
