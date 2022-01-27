<?php
namespace App\Services;

use App\Models\Log;

class NotificationService
{
    //create notification
    public function create($message, $model, $model_id, $url, $reciever_id)
    {
        $log = Log::create([
            'message'=>$message,
            'model'=>$model,
            'url'=>$url,
            'reciever_id'=>$reciever_id,
            'model_id'=>$model_id
        ]);

        return response()->json(['status'=>'ok','log'=> $log], 200);
    }
}
