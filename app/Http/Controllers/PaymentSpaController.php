<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Payment;
use Illuminate\Support\Facades\Validator;

class PaymentSpaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Payment::paginate(5);
        return Inertia::render('Payments',['payments'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render(
            'Payments/Create'
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'merchant_id' => ['required'],
        ])->validate();
        $request['notify_url']='https://abc.com';
        $request['return_url']='https://efg.com';
        $request['sign']='md5';

        Payment::create($request->all());
  
        return redirect()->back()
                    ->with('message', 'Article Created Successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Validator::make($request->all(),[
            'merchant_id'=>['required'],
        ])->validate();
        if($request->has('id')){
            Payment::find($request->input('id'))->update($request->all());
            return redirect()->back()
                ->with('message','Payment Updated Successful.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $payment=Payment::find($id);
        if($payment){
            $payment->delete();
            return redirect()->back()
                ->with('message', 'Blog Delete Successfully');

        }
    }
}
