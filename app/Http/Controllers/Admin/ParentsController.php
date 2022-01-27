<?php

namespace App\Http\Controllers\Admin;

use App\Models\Parents;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreParentRequest;

class ParentsController extends Controller
{
    //create websites
    public function create(StoreParentRequest $request)
    {
        $parent = Parents::create($request->validated());

        if ($parent) {
            $message = 'Parent Created Successfully!';
        }

        return redirect('/admin/websites')->with(['message' => $message]);
    }
}
