<?php

namespace App\Http\Controllers\Admin;

use ZipArchive;
use DOMDocument;
use HTMLPurifier;
use App\Models\Link;
use App\Models\Task;
use App\Models\User;
use App\Models\Payout;
use App\Models\Region;
use App\Models\Website;
use HTMLPurifier_Config;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
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
        $task = Task::create([
            'task'=>$request->task,
            'topic'=>$request->topic,
            // 'word_limit'=>$request->word_limit,
            // 'time_limit'=>$request->time_limit,
            'region_target'=>$request->region_target,
            'website_id'=>$request->website_id,
            'assigned_to'=>$request->assigned_to,
            'instructions'=>$request->instructions,
            'task_type'=>$request->task_type,
            'task_given_on'=>date("Y-m-d H:i:s")
        ]);

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
        $publishers = Publisher::all();
        $links = Link::all();
        $assigned_user = User::where('id',$task->assigned_to)->first(['name']);
        $payouts = Payout::where(['task_id'=>null, 'user_id'=>$task->assigned_to])->get();

        return view('admin/edit-task')->with(['regions'=>$regions, 'websites'=>$websites,
                                            'task'=>$task, 'assigned_user'=>$assigned_user,
                                            'payouts'=>$payouts, 'publishers'=>$publishers,
                                            'links'=>$links]);
    }

    //update task
    public function update(StoreTaskRequest $request)
    {
        // dd($request->all());
        $task = Task::findOrFail($request->task_id);
        $task->update([
            'task'=>$request->task,
            'topic'=>$request->topic,
            // 'word_limit'=>$request->word_limit,
            // 'time_limit'=>$request->time_limit,
            'region_target'=>$request->region_target,
            'website_id'=>$request->website_id,
            'assigned_to'=>$request->assigned_to,
            'instructions'=>$request->instructions,
            'task_type'=>$request->task_type
        ]);

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
    }

    //submit task
    public function submitTask(SubmitTaskRequest $request)
    { 
        if ($request->hasFile('document')) {
            //get document word count
            $doc_string = docx2text($request->file('document'));
            $doc_count = str_word_count($doc_string);

            //process doc
            $fileNameToStore = process_image($request->file('document'));

            //store doc
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
                'word_count'=>$doc_count,
                'file_path'=>$fileNameToStore,
                'status'=>'Submitted',
                'task_submitted_on'=>date("Y-m-d H:i:s"),
            ]);

            if ($tasks) {
                $message = 'Task Document Uploaded!';
            }
    
            return redirect('/task/conversations/'.$task->id)->with(['message'=>$message]);
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

    //search tasks
    public function searchUser(Request $request)
    {
        $searchData = $request->input('query');
        $searchColumn = $request->input('search_column');
        $tasks= '';

        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);
        $searchData = $purifier->purify($searchData);
        $searchColumn = $purifier->purify($searchColumn);

        if (!is_null($searchData)) {
            if ($searchColumn==='name') {
                $tasks = DB::table('tasks as t')
                            ->join('users as u','u.id','t.assigned_to')
                            ->where('u.name','like', "%$searchData%")
                            ->select('t.*')
                            ->paginate(50);
            }elseif ($searchColumn==='date') {
                $tasks = Task::where('task_given_on', 'like', "%$searchData%")->paginate(50);
            }elseif ($searchColumn==='desc') {
                $tasks = Task::where('task', 'like', "%$searchData%")->paginate(50);
            }elseif ($searchColumn==='type') {
                $tasks = Task::where('task_type', 'like', "%$searchData%")->paginate(50);
            }elseif ($searchColumn==='region') {
                $tasks = DB::table('tasks as t')
                            ->join('regions as r','r.id','t.region_target')
                            ->where('r.name','like', "%$searchData%")
                            ->select('t.*')
                            ->paginate(50);
            }elseif ($searchColumn==='website') {
                $tasks = DB::table('tasks as t')
                            ->join('websites as w','w.id','t.region_target')
                            ->where('w.website_code','like', "%$searchData%")
                            ->select('t.*')
                            ->paginate(50);
            }
        }

        if ($tasks) {
            return view('admin/tasks')->with(['tasks'=> $tasks]);
        }else{
            return redirect('tasks/')->with(['message'=>'invalid search column']);
        }

    }
}
