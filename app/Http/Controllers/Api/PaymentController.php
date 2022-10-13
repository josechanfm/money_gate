<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Requests\StorePaymentRequest;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = Payment::all();
        return response()->json([
            'payments'=>$payments,
            'status'=>true,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePaymentRequest $request)
    {
        $payment=Payment::create([
            'merchant_id'=>$request->merchant_id,
            'merchantTid'=>$request->merchantTid,
            'channel'=>$request->channel??"",
            'channel_ext'=>$request->channel_ext??"",
            'merchant_order_id'=>$request->merchant_order_id,
            'merchant_user_id'=>$request->merchant_user_id,
            'currency'=>$request->currency??'MOP',
            'amount'=>$request->amount,
            'timeout'=>$request->timeout??900,
            'notify_url'=>$request->notify_url??'http://abc.com',
            'return_url'=>$request->return_url??'http://efg.com',
            'sign'=>$request->sign??'sign',
            'status'=>$request->status??'START',
            'result'=>"",
        ]);
        return response()->json([
            'status'=>true,
            'message'=>'Payment Created successfully!',
            'payment'=>$payment
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        return response()->json([
            'status'=>'true',
            'payment'=>$payment
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
