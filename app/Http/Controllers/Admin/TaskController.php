<?php

namespace App\Http\Controllers\Admin;

use App\Models\Task;
use App\Models\User;
use App\Models\Region;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreTaskRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ReviewTaskRequest;
use App\Http\Requests\SubmitTaskRequest;

class TaskController extends Controller
{
    //return task page
    public function index()
    {
        $user = Auth::user();
        if ($user->type === 'Admin') {
            $tasks= Task::latest()->paginate(10);
        } else {
            $tasks = Task::where('assigned_to',$user->id)->latest()->paginate(10);
        }

        return view('admin/tasks')->with(['tasks' => $tasks]);
    }

    //create view task
    public function createView()
    {
        $regions = Region::all();
        $websites = Website::all();

        return view('admin/create-task')->with(['regions'=>$regions, 'websites'=>$websites]);
    }

    //create task
    public function store(StoreTaskRequest $request)
    {
        $task = Task::create($request->validated());

        if ($task) {
            $message = 'Task Created Successfully!';
        }

        return redirect('/task')->with(['message' => $message]);
    }

    //edit view task
    public function editView($id)
    {
        $task = Task::findOrFail($id);
        $regions = Region::all();
        $websites = Website::all();
        $assigned_user = User::where('id',$task->assigned_to)->first(['name']);

        return view('admin/edit-task')->with(['regions'=>$regions, 'websites'=>$websites,
                                            'task'=>$task, 'assigned_user'=>$assigned_user]);
    }

    //update task
    public function update(StoreTaskRequest $request)
    {
        $task = Task::findOrFail($request->task_id);
        $task->update($request->validated());

        if ($task) {
            $message = 'Task Updated Successfully!';
        }

        return redirect()->back()->with(['message' => $message]);
    }

    //submit task view
    public function submitView($id)
    {
        $task = Task::findOrFail($id);

        return view('admin/submit-task')->with(['task'=>$task]);
        // dd($id);
    }

    //submit task
    public function submitTask(SubmitTaskRequest $request)
    {
        
        if ($request->hasFile('document')) {
            //process image
            $fileNameToStore = process_image($request->file('document'));

            //store image
            $path = $request->file('document')->storeAs('public/tasks', $fileNameToStore);

            //get old task doc if exist
            $task = Task::where('id',$request->task_id)->firstOrFail();
            if ($task) {
                $task_document = $task->file_path;
                if ($task_document) {
                    unlink(storage_path("app/public/tasks/".$task_document));
                }
            }

            $tasks = $task->update([
                'file_path'=>$fileNameToStore,
                'status'=>'Submitted',
            ]);

            if ($tasks) {
                $message = 'Task Document Uploaded!';
            }
    
            return redirect('/task')->with(['message'=>$message]);
        }
    }

    //review page
    public function reviewView($id)
    {
        $task = Task::findOrFail($id);

        return view('admin/review-task')->with(['task'=>$task]);
    }

    //submit review
    public function submitReview(ReviewTaskRequest $request)
    {
        $task = Task::findOrFail($request->task_id);
        $task->update($request->validated());

        if ($task) {
            $message = 'Task Reviewed Successfully!';
        }

        return redirect()->back()->with(['message' => $message]);
    }

    //download document
    public function downloadDocument(Request $request)
    {
        $task = Task::findOrFail($request->task_id);
        // dd($task);

        $file =  "/storage/tasks/" . $task->file_path;

        $headers = ['Content-Type: file/docx'];
// dd($file);
Storage::download($file);
        // if (file_exists($file)) {
        //     return \Response::download($file, $task->file_path, $headers);
        // } else {
        //     echo('File not found.');
        // }
    }
}
