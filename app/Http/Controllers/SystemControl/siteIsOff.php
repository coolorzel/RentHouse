<?php

namespace App\Http\Controllers\SystemControl;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;

class siteIsOff extends Controller
{
    public function index () {
        if (Settings::where('name', 'page_available')->first()->value == '0')
            return view('site.app.siteIsOff');
        else
            return redirect()->route('index');
    }
}
