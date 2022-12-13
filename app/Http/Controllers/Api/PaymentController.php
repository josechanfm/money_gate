<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Date;
use Carbon\Carbon;

class PaymentController extends Controller
{
    protected $merchant_id;

    protected $public_key;

    public function __construct()
    {
        $this->merchant_id = config('payment.luso.merchant_id');
        $this->public_key = config('payment.luso.public_key');

        $this->host = 'https://aopuat.lusobank.com.mo/';
    }
    

    public function create_order( Request $request )
    {
        $validated = $request->validate([
            'currency' => ['required', Rule::in(['MOP','HKD'])],
            'amountTotal' => 'required|integer|min:0',
            // Gateway 回傳這個Number, 即報名編號/繳費編號等等. 用來識別是哪一個筆費用
            'merOrderNo' => 'required',
            'merchantUserNo' => 'required',
            'order' => 'array',
                'order.*.amount' => '',
                'order.*.name' => 'required',
            'payer' => 'array',
                'payer.userType' => '',
                'payer.payerName' => '',
                'payer.citizenIdNumber' => '', 
            'notifyUrl' => '',
        ]);

        // dd($validated);
        $order = $this->order( $validated );

        return response()->json( $order );
    }
    
    public function query_order( Request $request ){
        $validated = $request->validate([
            'orderNo' => 'required'
        ]);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->host."gateway/mer/payment/".$validated['orderNo'] );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($ch);
        
        curl_close ($ch);

        return response( $response );
    }

    private function order( $data ){

        // Order Amount
        $orderAmount = [ 'amount' => 0 , 'currency' => $data['currency'] ];

        // Sub Order 
        $cmmAmtMixs = [];
        foreach($data['order'] as $k => $v){

            // The amount is more than 0
            if( (int) $v['amount'] > 0 ){
                $cmmAmtMixs[$k] = [
                    "amountType" => range('A', 'Z')[$k],
                    "amountDescribe" => $v['name'],
                    "mixAmount" => [
                        "amount" => $v['amount'],
                        "currency" => $data['currency'],
                    ]
                ];
                $orderAmount['amount'] += (INT) $v['amount'];
            }
        }
        $orderAmount['amount'] = (string) $orderAmount['amount'];

        $order = [
            "merchantInfo" => [
                "merchantId" => $this->merchant_id,
                "merchantNotifyUrl" => $data['notifyUrl'],
            ],
            "order" => [
                // order number, 訂單號, 
                "merOrderNo"=> $data['merOrderNo'],
                "merchantUserNo"=> 'C22050231'.rand(00000,99999),
                // Order 30分鐘後過期
                "orderExceedTime" => Carbon::now()->addMinutes(60)->format("Y-m-d H:i:s"),
                "cmmAmtMixs" => $cmmAmtMixs,
                "orderAmount" => $orderAmount
            ],
            "payer" => $data['payer']
        ];
        $body = json_encode($order);
        $signature = md5( $body.$this->public_key );

        $headers = [
            'merchantId: '.$this->merchant_id,
            'Content-Type: application/json',
            'signature: '.$signature
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->host."gateway/mer/createOrder");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$body);
        curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
        
        $resp = curl_exec($ch);

        curl_close ($ch);

        Order::create([
            'amount' => $orderAmount['amount'],
            'currency' => $orderAmount['currency'],
            'merchantOrderNumber' => $data['merOrderNo'],
            "merchantUserNo"=> $data['merchantUserNo'],
            'order' => json_encode($order['order']),
            'payer' => json_encode($order['payer']),
            'send_json' => $body,
            'result_json' => $resp
        ]);

        $resp = json_decode($resp);
        return [
            'response' => $resp,
            'order' => $body,
        ];

    }


    public function notify( Request $request ){

    }
}