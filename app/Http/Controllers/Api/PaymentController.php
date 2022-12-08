<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Date;
use Carbon\Carbon;

class PaymentController extends Controller
{

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

    public function order( ){
        $currency = "MOP"; // $payment['currency'];

        $order = [
            [
                "amount" => "1000",
                "name" => "xxx課程學費"
            ],[
                "amount" => "1000",
                "name" => "xxx課程報名費"  
            ]
        ];

        $payer = [
            "userType" => "L",
            "payerName" => "leong chi fong",
            "citizenIdNumber" => "12345678",
        ];

        $cmmAmtMixs = [];
        $orderAmount = [ 'amount' => 0 , 'currency' => $currency ];
        foreach($order as $k => $v){
            $cmmAmtMixs[$k] = [
                "amountType" => range('A', 'Z')[$k],
                "amountDescribe" => $v['name'],
                "mixAmount" => [
                    "amount" => $v['amount'],
                    "currency" => $currency,
                ]
            ];
            $orderAmount['amount'] += (INT) $v['amount'];
        }

        $merchant_id = config('payment.merchant_id');
             
        $public_key = config('payment.public_key');

        $order = [
            "merchantInfo" => [
                "merchantId" => $merchant_id,
                "merchantNotifyUrl" => url("/api/payments/notify"),
            ],
            "order" => [
                // order number, 訂單號, 
                // 年月日時分 + 四位流水號 + 隨機數3位
                "merOrderNo"=> $this->getOrderId(),
                // 報名編號/學生編號, 建議使用報名編號特定哪一筆學費
				// "merchantUserNo" => $payment['identifyNumber'],
                "orderExceedTime" => Carbon::now()->addMinutes(30),
                "cmmAmtMixs" => $cmmAmtMixs,
                "orderAmount" => $orderAmount
            ],
            "payer" => $payer
        ];
        $body = json_encode($order);
        $key = md5( $body.$public_key );

        return $order;
        // $response = Http::post('http://example.com/users', $order);
    }

    public function notify( Request $request ){

    }
}