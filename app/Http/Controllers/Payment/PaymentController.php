<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Payment;
use App\Http\Requests\StorePaymentRequest;
use Carbon\Carbon;

class PaymentController extends Controller
{
    public function index()
    {
        echo Carbon::now();
        // $data = Payment::orderBy('id','desc')->paginate(10);
        // $payload = response()->json($data);
        
        // return response()->json($payload);
        $data=Payment::get();
        // echo $e;
        $data=['payments'=>$data];

        // echo json_encode($data);

       // $data = Payment::orderBy('id','desc')->paginate(10);
        return Inertia::render('Payments/Dashboard', $data);
    }

    public function newPayment()
    {
        // dd(request()->route());
        Payment::insert([
            'merchantTid' => 'abc',
            'merchant_id' => 'abc',
            'merchant_order_id' => 543,
            'currency' => 'MOP',
            'amount' => '0',
            'merchant_user_id' => '1',
            'timeout' => '30',
            'notify_url' => 'https://test.com/',
            'return_url' => 'https://test.com/',
            'sign' => 'ABC',
            'status' => 'Success',
        ]);
    }

    public function table_list(Request $request)
    {
        if($request->filter=='all'){
            $data = Payment::orderBy($request->sorter,$request->order)->paginate($request->pageSize);
        }else{
            $data = Payment::where('result',$request->filter)->orderBy($request->sorter,$request->order)->paginate($request->pageSize);

        }
        return response()->json($data);
    }
    public function create()
    {
        return Inertia::render(
            'Payments/Create'
        );
    }
    
    public function store(StorePaymentRequest $request)
    {
        $paymentApi=new Api\PaymentController;
        $request->sign=md5(json_encode($request->all()));
        //$result=json_decode($paymentApi->store($request),true);
        $result=$paymentApi->store($request);
        if($result->original['status']==true){
            return redirect()->route('payment.index')
                ->with('message','Payment Store Successful.')->with('result',$result);
        }
        return redirect()->back()->withErrors([
            'api'=>'Something wrong on the API payment!'
        ]);

    }
}
