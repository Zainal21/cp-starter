<?php

namespace App\Http\Controllers\Cp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a dashboard hoe page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cp.dashboard');
    }
}
