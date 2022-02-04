<?php

namespace App\Http\Controllers\Admin;

use App\Models\Task;
use App\Models\Feedback;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\NotificationService;
use App\Http\Requests\StoreFeedbackRequest;

class FeedbackController extends Controller
{
    protected $NotificationService;
    
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct(NotificationService $NotificationService)
    {
        $this->NotificationService = $NotificationService;
    }
    
    //save feedback
    public function saveFeedback(StoreFeedbackRequest $request)
    {
        $feedback = Feedback::firstOrNew([
            'task_id' => $request->task_id,
        ]);
        $feedback->feedback = $request->feedback;
        $feedback->save();

        $task = Task::findOrFail($request->task_id);

        if ($feedback) {
            $task->update([
                'status'=>'Feedback'
            ]);
            $this->NotificationService->create(
                'A feedback has been given for '. ' '. $task->task.' '. ' task by '.' '.Auth::user()->name ,
                'Feedback',
                $feedback->id,
                'task/conversations/'.$task->id,
                $task->assigned_to,
            );
            $message = 'Task Feedback Sent!';

            return back()->with(['message'=>$message]);
        }

    }
}
