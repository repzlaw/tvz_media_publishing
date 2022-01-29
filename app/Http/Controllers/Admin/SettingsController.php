<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Configuration;
use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    //settings view
    public function index()
    {
        $settings = Configuration::all();

        return view('admin.settings')->with(['login_email'=>$settings[0]->value, 'new_task_email'=>$settings[1]->value,
                                            'task_coversation_email'=>$settings[2]->value
                                        ]);
    }

    //save setting
    public function save(Request $request)
    {
        $setting = '';
        if ($request->has('login_email') && $request->has('new_task_email') && $request->has('task_coversation_email')) {
            $set = Configuration::where('key','login_email')->first();
            $setting = $set->update([
                'value'=> $request->login_email,
            ]);

            $set = Configuration::where('key','new_task_email')->first();
            $setting = $set->update([
                'value'=> $request->new_task_email,
            ]);

            $set = Configuration::where('key','task_coversation_email')->first();
            $setting = $set->update([
                'value'=> $request->task_coversation_email,
            ]);
        }
        if ($setting) {
            return back()->with('message','settings saved successfully');
        }
    }
}
