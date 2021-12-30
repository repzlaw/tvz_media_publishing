<?php

namespace App\Http\Controllers\Admin;

use App\Models\Link;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLinkRequest;

class LinkController extends Controller
{
    /**
     * Only auth for "admin" guard are allowed
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    //store link
    public function store(StoreLinkRequest $request)
    {
        $link = link::create($request->validated());

        if ($link) {
            $message = 'link Created Successfully!';
        }

        return response()->json(['link'=>$link, 'message'=>$message]); 
    }

    //map link to task
    public function mapToTask(Request $request)
    {
        $task  = Task::findOrFail($request->task_id);
        $link  = Link::findOrFail($request->link_id);

        $task->update([
            'link_id'=>$request->link_id,
            'published_url'=>$request->url,
            'published_date'=>$request->published_date
        ]);
        
        return $link;
    }
}
