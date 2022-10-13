<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Payment;
use App\Http\Requests\StorePaymentRequest;

class PaymentController extends Controller
{
    public function index()
    {
        $data = Payment::orderBy('id','desc')->paginate(10);
        return Inertia::render('Payments/Dashboard',['payments'=>$data]);
    }

    public function table_list(Request $request){
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
        $result=$paymentApi->store($request);
        return redirect()->route('payment.index')
            ->with('message','Payment Updated Successful.')->with('result',$result);
    }
}
