<?php

namespace App\Http\Controllers\Admin;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreTaskRequest;
use App\Models\Region;

class TaskController extends Controller
{
    //return task page
    public function index()
    {
        $tasks= Task::paginate(10);

        return view('admin/tasks')->with(['tasks' => $tasks]);

    }

    //create view task
    public function createView()
    {
        $regions = Region::all();

        return view('admin/create-task')->with(['regions'=>$regions]);
// dd(34);
    }

    //create task
    public function store(StoreTaskRequest $request)
    {
        $task = Task::create($request->validated());

        if ($task) {
            $message = 'Task Created Successfully!';
        }

        return redirect()->back()->with(['message' => $message]);
    }
}
