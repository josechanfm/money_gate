<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Order;
use App\Http\Requests\StorePaymentRequest;

class OrderController extends Controller
{
    public function index()
    {
        $data=Order::orderBy('id','DESC')->get();
        // echo $e;
        $data=['orders'=>$data];

        return Inertia::render('Orders/Dashboard', $data);
    }

}