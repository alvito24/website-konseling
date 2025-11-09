<?php

namespace App\Models\Traits;

trait HasRoles
{
    public function hasRole($role)
    {
        return $this->role === $role;
    }

    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    public function isCounselor()
    {
        return $this->hasRole('counselor');
    }

    public function isStudent()
    {
        return $this->hasRole('student');
    }
}