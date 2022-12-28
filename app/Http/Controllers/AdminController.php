<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Http;
use App\Models\Order;

class AdminController extends Controller
{
    public function index(){
        $data=[
            'users'=>500,
        ];

        $orders = Order::orderBy('id','DESC')->get();

        return Inertia::render('Admin',compact('data','orders'));
    }

    public function http_api(){
        $response = Http::get('http://localhost:8000/api/list_payments');
        //$response="My response";
        echo $response;
    }
}
