<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

   
    public function viewAny(User $user)
    {
        return true;
    }

    
    public function view(User $user, Post $post)
    {
        return true;
    }

   
    public function create(User $user)
    {
        foreach ($user->roles as $role) {
            if ($role->role_name === 'admin' || $role->role_name === 'blogger' || $role->role_name === 'editor') {
                return true;
            }
        }
        return true;
    }

    
    public function update(User $user, Post $post)
    {
        foreach ($user->roles as $role) {
            if ($role->role_name === 'admin') {
                return true;
            }
        }
        return $user->id === $post->user_id;
    }

    
    public function delete(User $user, Post $post)
    {
        foreach ($user->roles as $role) {
            if ($role->role_name === 'admin') {
                return true;
            }
        }
        return $user->id === $post->user_id;
    }

    
    public function restore(User $user, Post $post)
    {
        return true;
    }

    
    public function forceDelete(User $user, Post $post)
    {
        return true;
    }
}
