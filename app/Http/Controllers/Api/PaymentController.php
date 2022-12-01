<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PaymentController extends Controller
{

    public function store( Request $request )
    {
       
        $validated = $request->validate([
            'currency' => ['required', Rule::in(['MOP','HKD'])],
            'amountTotal' => 'required|integer|min:0',
            // Gateway 回傳這個Number, 即報名編號/繳費編號等等. 用來識別是哪一個筆費用
            'identifyNumber' => 'required',
            'order' => 'array',
            'order.*.amount' => 'required',
            'order.*.name' => 'required'
        ]);

        // dd($validated);

        return response( $validated );
    }

    public function order( ){
        
        $merchant_id = config('payment.merchant_id');
        
        $public_key = config('payment.public_key');

        

    }
}