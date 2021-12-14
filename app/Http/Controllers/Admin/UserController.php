<?php

namespace App\Http\Controllers\Admin;

use HTMLPurifier;
use HTMLPurifier_Config;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;

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
        $users = User::
                    // where('type','!=','Admin')->
                    paginate(50);

        return view('admin/user/index')->with(['users'=> $users]);

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
            'password'=> Hash::make($request->password),
        ]);

        if ($user) {
            $message = 'User Created Successfully!';
        }

        return redirect('/admin/users')->with(['message' => $message]);
    }

    //edit users
    public function edituser(StoreUserRequest $request)
    {
        $user = User::findOrFail($request->user_id);

        $update = $user->update([
            'name'=> $request->name,
            'email'=> $request->email,
            'type'=> $request->type,
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
