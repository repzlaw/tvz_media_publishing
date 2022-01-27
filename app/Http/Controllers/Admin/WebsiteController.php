<?php

namespace App\Http\Controllers\Admin;

use App\Models\Website;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWebsiteRequest;
use App\Models\Parents;
use App\Models\Region;

class WebsiteController extends Controller
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

    //websites page
    public function index()
    {
        $websites = Website::where('parent_id',NULL)->paginate(50);
        $regions = Region::all();
        $parents = Parents::with(['websites'])->orderBy('name','asc')->get();
        // return $parents;
        return view('admin/website/index')->with(['websites'=> $websites, 'regions'=> $regions, 'parents'=> $parents]);
    }

    //create websites
    public function create(StoreWebsiteRequest $request)
    {
        $website = Website::create($request->only('website_code','url','region_id','parent_id'));

        if ($website) {
            $message = 'Website Created Successfully!';
        }

        return redirect('/admin/websites')->with(['message' => $message]);
    }

    //edit websites
    public function edit(StoreWebsiteRequest $request)
    {
        $website = Website::findOrFail($request->website_id);

        $update = $website->update($request->only('website_code','url','region_id','parent_id'));

        if ($update) {
            $message = 'website Updated Successfully!';
        }

        return redirect()->back()->with(['message' => $message]);

    }

    //delete websites
    public function delete($id)
    {
        $delete = Website::where('id',$id)->delete();

        if ($delete) {
            $message = 'website Deleted Successfully!';
        }

        return redirect()->back()->with(['message' => $message]);
    }
}
