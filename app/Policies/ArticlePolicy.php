<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;
use App\Models\Role;
use Illuminate\Auth\Access\Response;

class ArticlePolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        $admin = Role::where('slug', 'admin')->first();
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
        $admin = Role::where('slug', 'admin')->first();
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool
    {
        $admin = Role::where('slug', 'admin')->first();
        return $user->hasRole('admin');
    }
}
