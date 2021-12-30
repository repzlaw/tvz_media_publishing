<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePayoutRequest;
use App\Models\Payout;
use App\Models\Task;
use GuzzleHttp\Promise\Create;

class PayoutController extends Controller
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

    //payout page
    public function index()
    {
        $payouts = Payout::paginate(50);

        return view('admin/payout/index')->with(['payouts'=> $payouts]);

    }

     //create view
     public function create()
     {
        return view('admin/payout/create-payout');
     }

    //store payout
    public function store(StorePayoutRequest $request)
    {
        if ($request->has('task_id')) {
            $payout = Payout::firstOrCreate([
                        'task_id'=>$request->task_id,
                        'user_id'=>$request->user_id,
            ]);
            $payout->status = $request->status;
            $payout->amount = $request->amount;
            $payout->save();

            return $payout;
        }

        $payout = Payout::create($request->validated());

        if ($payout) {
            $message = 'Payout Created Successfully!';
        }

        return redirect('admin/payouts/')->with(['message'=>$message]);
    }

    //edit payout view
    public function edit($id)
    {
        $payout = Payout::findOrFail($id);

        return view('admin/payout/edit-payout')->with(['payout'=> $payout]);
    }

    //update payout
    public function update(StorePayoutRequest $request)
    {
        $payout = Payout::findOrFail($request->payout_id);
        $payout->update($request->validated());
        
        if ($payout) {
            $message = 'Payout Update Successfully!';
        }

        return redirect('admin/payouts/')->with(['message'=>$message]);
    }

    //map payout to task
    public function mapToTask(Request $request)
    {
        $task  = Task::findOrFail($request->task_id);
        $payout  = Payout::findOrFail($request->payout_id);

        $task->update([
            'payout_id'=>$request->payout_id
        ]);

        $payout->update([
            'task_id'=>$request->task_id
        ]);
        
        return $payout;
    }
}
