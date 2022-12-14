<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Order;
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
        $sign=$request->sign;
        $data=$request->all();

        //unset($data['sign']);
        $data['sign']='sign';
        $verifySign=md5(json_encode($data));

        if($verifySign!=$sign){
            return response()->json([
                'status'=>false,
                'message'=>'Payment Created NOT successfully!',
                'data'=>$data
            ],200);
        }
        $request->sign=$verifySign;

        // if($sign=='md5'){
        //     return response()->json([
        //         'status'=>true,
        //         'message'=>'Payment Created successfully!',
        //         'data'=>$data
        //     ],200);
        // }else{
        //     return response()->json([
        //         'status'=>false,
        //         'message'=>'Payment Created NOT successfully!',
        //         'data'=>$data
        //     ],200);
        // }
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

    public static function order( $array , $publicKey ){

        $url = "https://app.icbcmo.site/api/v1/order";
        
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        //Set the array to string 
		//curl post array to string conversion AND concat the public key 
		$raw = http_build_query($array).$publicKey;

		//encrypt the string 
		$sign = md5( $raw );

		//push the sign to the array
		$array['sign'] = $sign;

		$payload = http_build_query($array);

		curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);

		$headers = array(
			"Content-Type: application/x-www-form-urlencoded",
        );
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		
		$resp = curl_exec($curl);
		curl_close($curl);

		$r = json_decode($resp);

        return $r;
        // dd( $request );
        // return response($request);
    }
}
