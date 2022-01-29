<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    //get page
    public function index()
    {
        $logs = Log::orderBy('created_at','desc')
                ->where(['reciever_id'=> Auth::id()])->paginate(30)->groupBy(function($item) {
            return $item->created_at->isoFormat('dddd MMMM D ');
       });
    //   return($logs); 
       return view('notification/index')->with(['logs'=>$logs]);

    }

    //go to notifcation url
    public function single(Log $log)
    {
        $log->update([
            'status'=>'seen'
        ]);

        return redirect('/'.$log->url);
    }
}
