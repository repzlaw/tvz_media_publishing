<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->type === 'Admin') {
            $tasks= Task::latest()->paginate(10);
        } else {
            $tasks = Task::where('assigned_to',$user->id)->latest()->paginate(10);
        }
        
        return view('home')->with(['tasks'=>$tasks]);
        
    }
}
