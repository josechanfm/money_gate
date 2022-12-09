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
    }
    

    public function create_order( Request $request )
    {
        $validated = $request->validate([
            'currency' => ['required', Rule::in(['MOP','HKD'])],
            'amountTotal' => 'required|integer|min:0',
            // Gateway 回傳這個Number, 即報名編號/繳費編號等等. 用來識別是哪一個筆費用
            'identifyNumber' => 'required',
            'order' => 'array',
                'order.*.amount' => '',
                'order.*.name' => 'required',
            'payer' => 'array',
                'payer.userType' => '',
                'payer.payerName' => '',
                'payer.citizenNumber' => '', 
            'returnUrl' => '',
        ]);

        // dd($validated);
        $response = $this->order( $validated );

        return response( $response );
    }
    
    public function query_order( $orderNum ){

    }

    public function getOrderId(){
        //Default order Code 
        $orderCode = Carbon::now()->format('ymd').'00001';
        
        $lastOrder = Order::latest()->first();

        if( $lastOrder == null){
            
        }else{
            // If the last order is created at today 
            $isToday = Carbon::parse( $lastOrder->created_at )->isToday() ;

            if( $isToday ){
                // Last Order 是今天的, 繼承 last code
                $orderCode = ( $lastOrder->order_code ) + 1;
            }
        }

        return $orderCode.rand(100, 999);
    }

    public function order( $data ){

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

        $order = [
            "merchantInfo" => [
                "merchantId" => $this->merchant_id,
                "merchantNotifyUrl" => url("/api/payments/notify"),
            ],
            "order" => [
                // order number, 訂單號, 
                // 年月日時分 + 四位流水號 + 隨機數3位
                "merOrderNo"=> $this->getOrderId(),
                "merchantUserNo"=> $data['identifyNumber'],
                // Order 30分鐘後過期
                "orderExceedTime" => Carbon::now()->addMinutes(30)->format("Y-m-d H:i:s"),
                "cmmAmtMixs" => $cmmAmtMixs,
                "orderAmount" => $orderAmount
            ],
            "payer" => $data['payer']
        ];
        $body = json_encode($order);
        $signature = md5( $body.$this->public_key );

        // ----
        // $response = Http::withHeaders([
        //     'merchantId' => $this->merchant_id,
        //     'Content-Type' => 'application/json',
        //     'signature' => $signature
        // ])->post('https://aopuat.lusobank.com.mo/gateway/mer/createOrder', $body);
        
        // ----
        $headers = [
            'merchantId: '.$this->merchant_id,
            'Content-Type: application/json',
            'signature: '.$signature
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://aopuat.lusobank.com.mo/gateway/mer/createOrder");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$body);
        curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
        
        $response = curl_exec($ch);
        curl_close ($ch);


        return $response;
    }

    public function notify( Request $request ){

    }
}