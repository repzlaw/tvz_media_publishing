<?php

namespace App\Http\Controllers\Admin;

use HTMLPurifier;
use HTMLPurifier_Config;
use App\Models\User;
use App\Models\Region;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use App\Models\Currency;

class UserController extends Controller
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

    //users page
    public function index()
    {
        $users = User::paginate(50);

        return view('admin/user/index')->with(['users'=> $users]);
    }

    //create view user
    public function createView()
    {
        $regions = Region::all();
        $currencys = Currency::all();

        return view('admin/user/create-user')->with(['regions'=>$regions, 'currencys'=>$currencys]);
    }

    //search users
    public function searchUser(Request $request)
    {
        $searchData = $request->input('query');
        $searchColumn = $request->input('search_column');
        $users= '';

        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);
        $searchData = $purifier->purify($searchData);
        $searchColumn = $purifier->purify($searchColumn);

        if (!is_null($searchData)) {
            if ($searchColumn==='id') {
                $users = User::where('id', 'like', "%$searchData%")->paginate(50);
            }elseif ($searchColumn==='name') {
                $users = User::where('name', 'like', "%$searchData%")->paginate(50);
            }elseif ($searchColumn==='email') {
                $users = User::where('email', 'like', "%$searchData%")->paginate(50);
            }
        }

        if ($users) {
            return view('admin/user/index')->with(['users'=> $users]);
        }else{
            return redirect('admin/users/')->with(['message'=>'invalid search column']);
        }

    }

    //create users
    public function createuser(StoreUserRequest $request)
    {
        $user = User::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'type'=> $request->type,
            'country'=> $request->country,
            'bank_details'=> $request->bank_details,
            'payout_per_word'=> $request->payout_per_word,
            'fixed_monthly_payout'=> $request->fixed_monthly_payout,
            'total_payout'=> $request->total_payout,
            'currency'=> $request->currency,
            'password'=> Hash::make($request->password),
        ]);

        if ($user) {
            $message = 'User Created Successfully!';
        }

        return redirect('/admin/users')->with(['message' => $message]);
    }

    //edit view user
    public function editView($id)
    {
        $regions = Region::all();
        $user = User::findOrFail($id);
        $currencys = Currency::all();


        return view('admin/user/edit-user')->with(['user'=>$user, 'regions'=>$regions, 'currencys'=>$currencys]);
    }

    //update users
    public function edituser(StoreUserRequest $request)
    {
        $user = User::findOrFail($request->user_id);

        $update = $user->update([
            'name'=> $request->name,
            'email'=> $request->email,
            'type'=> $request->type,
            'country'=> $request->country,
            'bank_details'=> $request->bank_details,
            'payout_per_word'=> $request->payout_per_word,
            'fixed_monthly_payout'=> $request->fixed_monthly_payout,
            'total_payout'=> $request->total_payout,
            'currency'=> $request->currency,
            'password'=> $request->password ? Hash::make($request->password) : $user->password,
        ]);

        if ($update) {
            $message = 'User Updated Successfully!';
        }

        return redirect()->back()->with(['message' => $message]);

    }

    //delete user
    public function delete($id)
    {
        $delete = User::where('id',$id)->delete();

        if ($delete) {
            $message = 'User Deleted Successfully!';
        }

        return redirect()->back()->with(['message' => $message]);
    }

}
