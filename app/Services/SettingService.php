<?php

namespace App\Services;

use App\Helpers\ResponseHelper;
use App\Services\SettingRepository;


class SettingService
{
    public function update($data)
    {
        $updateSetting = (new SettingRepository)->update($data);
        if(!$updateSetting){
            return ResponseHelper::error('Data konfigurasi website gagal di ubah');
        }
        return ResponseHelper::success($update, 'Data konfigurasi website berhasil di ubah');
    }
}