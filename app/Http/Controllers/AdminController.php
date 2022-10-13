<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Http;


class AdminController extends Controller
{
    public function index(){
        $data=[
            'users'=>500,
        ];
        return Inertia::render('Admin',compact('data'));
    }

    public function http_api(){
        $response = Http::get('http://localhost:8000/api/list_payments');
        //$response="My response";
        echo $response;
    }
}
