<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\NotificationService;
use App\Http\Requests\StoreNoteRequest;

class TaskNoteController extends Controller
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
    
    ////return task notes page
    public function index(Task $task)
    {
        $user = Auth::user();
        if ($user->type === 'Admin') {
            $task_notes= TaskNote::latest()->get();
        } else {
            $task_notes = TaskNote::where('status','Public')->latest()->get();
        }

        return view('task/notes/index')->with(['task' => $task, 'task_notes' => $task_notes]);
    }

    //save notes
    public function saveNotes(StoreNoteRequest $request)
    {
        $user = Auth::user();
        $task = Task::findOrFail($request->task_id);

        if ($user->type === 'Admin') {
            $task_note= TaskNote::create($request->validated());
        } else {
            $task_note = TaskNote::create([
                'task_id'=> $request->task_id,
                'note'=> $request->note,
                'status'=> 'public',
            ]);
            $this->NotificationService->create(
                'A note has been added for '. ' '. $task->task.' '. ' task by '.' '.Auth::user()->name,
                'TaskNote',
                $task_note->id,
                'task/notes/'.$task->id,
                $task->admin_id,
            );
        }
        return back()->with(['message'=>'note added successfully']);
    }

    //share notes
    public function shareNotes(Request $request)
    {
        $note = TaskNote::findOrFail($request->note_id);
        $task = Task::findOrFail($note->task_id);

        if ($note->status === 'Private') {
            $note->update([
                'status'=>'Public'
            ]);
            $this->NotificationService->create(
                'A note has been shared for '. ' '. $task->task.' '. ' task by '.' '.Auth::user()->name,
                'TaskNote',
                $note->id,
                'task/notes/'.$task->id,
                $task->assigned_to,
            );
        } else if($note->status === 'Public') {
            $note->update([
                'status'=>'Private'
            ]);
        }

        return $note;
    }
}
