<?php

namespace App\Services;

use App\Models\Role;
use App\Models\User;

class UserService
{
    public function getAllUsers()
    {
        return User::all();
    }

    public function createUser($data)
    {
        return User::create($data);
    }

    public function updateUser($id, $data)
    {
        $user = User::findOrFail($id); 
        $user->fill($data)->save();
        return $user;
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
    }

    public function getUser($id)
    {
        return User::findOrFail($id);
    }

    public function getAllRoles()
    {
        return Role::all();
    }
}
