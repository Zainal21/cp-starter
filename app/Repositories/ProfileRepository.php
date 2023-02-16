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
    public function getUserById($id)
    {
        return User::find($id);
    }
}