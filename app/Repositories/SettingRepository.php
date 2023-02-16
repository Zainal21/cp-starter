<?php

namespace App\Services;

use App\Models\Setting;

interface SettingContract
{
    public function update();
}

class SettingRepository implements SettingContract
{
    public function update($data)
    {
        return Setting::where('id', '<>', '0')->update($data);
    }
}