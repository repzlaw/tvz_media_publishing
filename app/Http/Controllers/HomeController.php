<?php

namespace App\Http\Controllers;

use App\Models\Log;
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
        $logs = Log::orderBy('created_at','desc')
                ->where(['reciever_id'=> Auth::id()])->paginate(50)->groupBy(function($item) {
            return $item->created_at->isoFormat('dddd MMMM D ');
        });

        return view('home')->with(['logs'=>$logs]);
        
    }
}
