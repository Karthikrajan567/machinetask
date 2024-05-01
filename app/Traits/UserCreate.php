<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Str;

trait UserCreate
{
    /**
     * Creates a new user with the given data and assigns a role to it.
     *
     * @param array $data The data for creating the user.
     * @param mixed $role The role to be assigned to the user.
     * @return User The newly created user.
     */
    public function createUser(array $data, $role)
    {
        $user = User::Create($data);
        $user->assignRole($role);
        return $user;
    }

}
