<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Models\TaskConversation;
use App\Http\Requests\StoreTaskConversationRequest;
use Illuminate\Support\Facades\Auth;

class TaskConversationController extends Controller
{
    //index
    public function index($task_id)
    {
        $task = Task::findOrFail($task_id);
        $conversations = TaskConversation::where('task_id',$task_id)->get();
        // return $conversations;
        return view('task.conversation.index')->with(['conversations'=>$conversations,'task'=>$task]);
    }

    //store conversations
    public function store(StoreTaskConversationRequest $request)
    {
        $fileNameToStore = NULL;
        if ($request->hasFile('attachment')) {
            //process doc
            $fileNameToStore = process_image($request->file('attachment'));

            //store doc
            $path = $request->file('attachment')->storeAs('public/tasks/attachments', $fileNameToStore);

        }
        $conversation = TaskConversation::create([
            'task_id'=>$request->task_id,
            'message'=>$request->message,
            'sender_id'=>Auth::id(),
            'file_path'=>$fileNameToStore,
        ]);

        return back()->with(['message'=>'Sent']);
    }
}
