<?php

namespace App\Http\Controllers\Cp;

use Illuminate\Http\Request;
use App\Services\SettingService;
use App\Http\Controllers\Controller;
use App\Http\Requests\SettingRequest;

class SettingController extends Controller
{
    public function index()
    {
        return view('cp.settings.index');
    }

    public function updateSetting(SettingRequest $request)
    {
        return (new SettingService)->update($request->validated());
    }
}
