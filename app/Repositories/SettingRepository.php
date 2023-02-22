<?php

namespace App\Repositories;

use App\Models\Setting;

interface SettingContract
{
    public function getCurrentSetting();
    public function update($data);
}

class SettingRepository implements SettingContract
{
    /**
     * Query for get current setting
     * 
     * @return The service that was store.
     */
    public function getCurrentSetting()
    {
        return Setting::first();
    }
    /**
     * Query for update site setting.
     * 
     * @param Request request The request object
     * 
     * @return The service that was store.
     */
    public function update($data)
    {
        return Setting::where('id', '<>', '0')->update($data);
    }
}