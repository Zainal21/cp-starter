<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Setting;

interface ProfileContract
{
    public function getUserById($id);
}

class ProfileRepository implements ProfileContract
{
    /**
     * Query for get user detail by id.
     * 
     * @param Id request The request string
     * 
     * @return The service that was find.
     */
    public function getUserById($id)
    {
        return User::find($id);
    }
}