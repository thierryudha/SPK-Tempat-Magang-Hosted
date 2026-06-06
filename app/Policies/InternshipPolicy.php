<?php

namespace App\Policies;

use App\Models\Internship;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class InternshipPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Internship $internship): bool
    {
        return $user->role === 'admin' || $user->id === $internship->user_id;
    }

    public function update(User $user, Internship $internship): bool
    {
        return $user->role === 'admin' || $user->id === $internship->user_id;
    }

    public function delete(User $user, Internship $internship): bool
    {
        return $user->role === 'admin' || $user->id === $internship->user_id;
    }
}
