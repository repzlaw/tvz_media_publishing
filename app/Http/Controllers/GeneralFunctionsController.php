<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GeneralFunctionsController extends Controller
{
    //search user
    public function searchUser(Request $request)
    {
        // dd($request->all());

        if ($request->ajax()) {
            $q = $request->input('q');
            $from = $request->input('from');
            $output = searchUser($q, $from);

            return $output;
        }
    }
}
