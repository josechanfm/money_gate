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

    protected $merchant_id = config('payment.merchant_id');
             
    protected $public_key = config('payment.public_key');

    public function create_order( Request $request )
    {
        $validated = $request->validate([
            'currency' => ['required', Rule::in(['MOP','HKD'])],
            'amountTotal' => 'required|integer|min:0',
            // Gateway 回傳這個Number, 即報名編號/繳費編號等等. 用來識別是哪一個筆費用
            'identifyNumber' => 'required',
            'order' => 'array',
            'order.*.amount' => 'required',
            'order.*.name' => 'required',
            'payer' => 'array',
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
                "orderExceedTime" => Carbon::now()->addMinutes(30),
                "cmmAmtMixs" => $cmmAmtMixs,
                "orderAmount" => $orderAmount
            ],
            "payer" => $data['payer']
        ];
        $body = json_encode($order);
        $signature = md5( $body.$this->public_key );

        $response = Http::withHeaders([
            'merchantId' => '1234567890',
            'Content-Type' => 'application/json',
            'signature' => $signature
        ])->post('http://aopuat.lusobank.com.mo/gateway/mer/createOrder', $body);

        return $order;
    }

    public function notify( Request $request ){

    }
}