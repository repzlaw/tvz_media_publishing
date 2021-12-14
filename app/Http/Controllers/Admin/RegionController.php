<?php

namespace App\Http\Controllers\Admin;

use App\Models\Region;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRegionRequest;

class RegionController extends Controller
{
    /**
     * Only auth for "admin" guard are allowed
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    //regions page
    public function index()
    {
        $regions = Region::paginate(50);

        return view('admin/region/index')->with(['regions'=> $regions]);

    }

    //create regions
    public function create(StoreRegionRequest $request)
    {
        $region = Region::create([
            'name'=> $request->name,
            'code'=> $request->code,
        ]);

        if ($region) {
            $message = 'Region Created Successfully!';
        }

        return redirect('/admin/regions')->with(['message' => $message]);
    }

    //edit regions
    public function edit(StoreRegionRequest $request)
    {
        $region = Region::findOrFail($request->region_id);

        $update = $region->update([
            'name'=> $request->name,
            'code'=> $request->code,
        ]);

        if ($update) {
            $message = 'Region Updated Successfully!';
        }

        return redirect()->back()->with(['message' => $message]);

    }

    //delete regions
    public function delete($id)
    {
        $delete = Region::where('id',$id)->delete();

        if ($delete) {
            $message = 'Region Deleted Successfully!';
        }

        return redirect()->back()->with(['message' => $message]);
    }
}
