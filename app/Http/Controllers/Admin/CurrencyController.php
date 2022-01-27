<?php

namespace App\Http\Controllers\Admin;

use App\Models\Currency;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCurrencyRequest;

class CurrencyController extends Controller
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

    //Currencys page
    public function index()
    {
        $currencys = Currency::paginate(50);

        return view('admin/currency/index')->with(['currencys'=> $currencys]);

    }

    //create Currencys
    public function create(StoreCurrencyRequest $request)
    {
        $currency = Currency::create([
            'name'=> $request->name,
            'code'=> $request->code,
            'symbol'=> $request->symbol,
        ]);

        if ($currency) {
            $message = 'Currency Created Successfully!';
        }

        return redirect('/admin/currencies')->with(['message' => $message]);
    }

    //edit Currencys
    public function edit(StoreCurrencyRequest $request)
    {
        $currency = Currency::findOrFail($request->currency_id);

        $update = $currency->update([
            'name'=> $request->name,
            'symbol'=> $request->symbol,
            'code'=> $request->code,
        ]);

        if ($update) {
            $message = 'Currency Updated Successfully!';
        }

        return redirect()->back()->with(['message' => $message]);

    }

    //delete Currencys
    public function delete($id)
    {
        $delete = Currency::where('id',$id)->delete();

        if ($delete) {
            $message = 'Currency Deleted Successfully!';
        }

        return redirect()->back()->with(['message' => $message]);
    }
}
