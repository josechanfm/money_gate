<?php

namespace App\Http\Controllers\Payment;

use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Api\PaymentController as paymentApi;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Payment;
use App\Models\Order;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
        return Inertia::render('Payments_spa',['payments'=>$data]);
    }

    // Post to here 
    public function createOrder( Request $request ){
        $requestSample = '{
            "currency" => "MOP",
            "amountTotal" => "300" 
            "merchantId" => "1234567890", 
            "finishUrl" => "https://example.com/finish"
            "notifyUrl" => "https://example.com/notify"
            "order" => [
                {
                    "amount" => "250",
                    "name" => "學費"
                }
                {
                    "amount" => "50",
                    "name" => "手續費"
                }
            ]
        }';

        $validated = $request->validate([
            'currency' => ['required', Rule::in(['MOP'])],
            'amountTotal' => 'required|integer|min:0',
            'merchantId' => 'exists:merchants',
            'order' => 'array',
            'order.*.amount' => 'required',
            'order.*.name' => 'required'
        ]);

        // dd($validated);

        return response( $validated );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render(
            'Payments_spa/Create'
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

    public function order(Request $request){
        // Post Value
        $bank = $request->bank;
        $amount = $request->amount;
        $application_id = $request->application_id;

        //Config 
        //Production的url 與 Development的url不同 放到config
        $nUrl = url('/payment/payments/notify_order');
        $rUrl = url('/payment/payments/return_order');
        $pKey = '5Ui2gHeFYwFL7CxpW1XAehAJXnrdGTWk';

        //Set the order Id 
        //>>
        //Random number add behind order id 
        $rand = substr("00" . rand(001, 999), -3);

        $order_code = $this->getOrderId($application_id);
        $merchantOrderId = $bank . $order_code . $rand;
        $currency = 'MOP';
        $status = 'pending';
        
        $param = array(
            //線上支付金額以分為基準, 加兩個digit為小數點後兩位
            'amount' => $amount. '00',
            'channel' => 'ICBCOnlinePosOrder',
            'channelExt' => '{"language":"en"}',
            'currency' => $currency,
            'merchantId' => '011901200001005',
            'merchantOrderId' => $merchantOrderId,
            'notifyUrl' => $nUrl,
            'returnUrl' => $rUrl,
            'timeout' => '300',
        );
        $array = ($param);

        //Store to db
        $json = json_encode($param);
        $order = array(
            'application_id' => $application_id,
            'amount' => $amount,
            'currency' => $currency,
            'merchantOrderId' => $merchantOrderId,
            'bank' => $bank,
            'order_code' => $order_code,
            'rand' => $rand,
            'json' => $json,
            'status' => $status,
            'return_url' => $rUrl,
            'notify_url' => $rUrl,
        );
        Order::insertOrIgnore($order);

        $publicKey = $pKey;

        $api = new paymentApi;

        $r = $api->order($param, $publicKey);
		
        if($r->retCode == '200'){
            return Inertia::location($r->returnObj->redirectUrl);
        }

        return response( 'Order Error.');
    }

     //Set order the id 
    // bank + y + m + d + sequence number
    public function getOrderId($applicationId)
    {
        $order_id = Order::orderBy('created_at', 'desc')->first();
        
        // $order_id = $this->db->order_by('id', "desc")->limit(1)->get('orders')->row();
        if (empty($order_id->order_code)) {
            //If no any order id
            $code = Date("y") . Date("m") . Date("d") . "00001";
        } else {

            $old_order_code = substr($order_id->order_code, 0, 6);

            //check the last order id whether is create at today
            if ( $old_order_code == Date("ymd")) {
                //Add up the last num
                $num = substr($order_id->order_code, -4) + 1;
                $code = Date("y") . Date("m") . Date("d") . substr("00000" . $num, -5);
            } else {
                //count new number
                $code = Date("y") . Date("m") . Date("d") . "00001";
            }
        }

        return $code;
    }
}
