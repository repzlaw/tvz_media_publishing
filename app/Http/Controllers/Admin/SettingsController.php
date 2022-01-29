<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Configuration;
use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    //settings view
    public function index(Request $request)
    {
        $settings = Configuration::all();
        return $settings;

        return view('admin.settings')->with(['captcha_enable'=>$settings[0]->value, 'captcha_site_key'=>$settings[1]->value,
                                            'captcha_secret_key'=>$settings[2]->value, 'captcha_login'=>$settings[3]->value,
                                        ]);
    }
}
