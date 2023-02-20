<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

interface UserContract
{
    public function getUsers();
    public function getRoles();
    public function getUserById($id);
    public function createNewUser($data);
    public function deleteUsers($id);
}

class UserRepository implements UserContract
{
    public function getUsers()
    {
        return User::latest()->get();
    }

    public function getRoles()
    {
        return Role::all();
    }
    
    public function getUserById($id)
    {
        return User::find($id);
    }
    
    public function createNewUser($data)
    {
        return User::create($data);
    }
    
    public function deleteUsers($id)
    {
        return User::find($id)->delete();
    }
}