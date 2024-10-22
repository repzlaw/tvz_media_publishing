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
                ->where(['reciever_id'=> Auth::id()])->paginate(50)->groupBy(function($item) {
            return $item->created_at->isoFormat('dddd MMMM D ');
       });
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

    //mark read or unread
    public function changeStatus(Request $request)
    {
        $log = Log::findOrFail($request->notification_id);
        if ($log->status === 'unseen') {
            $log->update([
                'status'=>'seen'
            ]);
        } else if($log->status === 'seen') {
            $log->update([
                'status'=>'unseen'
            ]);
        }

        return $log;
    }
}
