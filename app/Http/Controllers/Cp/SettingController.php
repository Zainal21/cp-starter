<?php

namespace App\Http\Controllers\Cp;

use Illuminate\Http\Request;
use App\Services\SettingService;
use App\Http\Controllers\Controller;
use App\Http\Requests\SettingRequest;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:site-setting-edit', ['only' => ['index','updateSetting']]);
    }
    /**
     * Show the form for change setting page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = (new SettingService)->getSetting();
        return view('cp.settings.index', compact('settings'));
    }
    /**
     * an action to update website setting
     *
     * @return \Illuminate\Http\Response
     */
    public function updateSetting(SettingRequest $request)
    {
        return (new SettingService)->update($request->validated());
    }
}
