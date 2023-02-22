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
    /**
     * query for all latest users
     * 
     * @param Request request The request object
     * 
     * @return The service that was store.
     */
    public function getUsers()
    {
        return User::latest()->get();
    }
    /**
     * query for get all roles
     * 
     * @param Request request The request object
     * 
     * @return The service that was store.
     */
    public function getRoles()
    {
        return Role::all();
    }
    /**
     * query for find user by id
     * 
     * @param Request request The request object
     * 
     * @return The service that was store.
     */
    public function getUserById($id)
    {
        return User::find($id);
    }
    /**
     * query for create new user
     * 
     * @param Request request The request object
     * 
     * @return The service that was store.
     */
    public function createNewUser($data)
    {
        return User::create($data);
    }
    /**
     * query for delete user by id
     * 
     * @param Request request The request object
     * 
     * @return The service that was store.
     */
    public function deleteUsers($id)
    {
        return User::find($id)->delete();
    }
}