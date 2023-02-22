<?php

namespace App\Services;

use App\Helpers\ResponseHelper;
use App\Repositories\SettingRepository;

class SettingService
{
    /**
     * service to get current site setting
     * 
     * @return The service that was store.
     */
    public function getSetting()
    {
        $settings = (new SettingRepository)->getCurrentSetting();
        if(!$settings){
            return abort(500);
        }
        return $settings;
    }
    /**
     * service to update site setting
     * 
     * @param Request request The request object
     * 
     * @return The service that was store.
     */
    public function update($data)
    {
        $update = (new SettingRepository)->update($data);
        if(!$update){
            return ResponseHelper::error('Data konfigurasi website gagal di ubah');
        }
        return ResponseHelper::success($update, 'Data konfigurasi website berhasil di ubah');
    }
}