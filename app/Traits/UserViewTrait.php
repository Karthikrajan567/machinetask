<?php

// app/Traits/UserViewTrait.php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

trait UserViewTrait
{
    /**
     * Filter the query based on the role, company_id, and eager loaded roles.
     *
     * @param Builder $query The query to filter
     * @param mixed $request The request object
     * @param mixed $role The role to filter by
     * @param int $perPage The number of items per page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getUserViewData(Builder $query, $request, $role, $perPage = 10)
    {
        // Filter by role, company_id, and eager load roles
        $query->role($role)
            ->where('company_id', auth()->user()->company_id)
            ->with('roles')
            ->withTrashed();

        // Filter by name if a search query is provided
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        // Paginate the results
        return $query->paginate($perPage);
    }

    /**
     * Retrieves the details of a user based on their role and company ID.
     *
     * @param string $role The role of the user to retrieve.
     * @return \Illuminate\Database\Eloquent\Collection|User[] The collection of users matching the given role and company ID.
     */
    public function userdetails($role)
    {
        $user = User::role($role)
        ->where('company_id', auth()->user()->company_id)
        ->with('roles')
        ->get();
        return $user;
    }
}
