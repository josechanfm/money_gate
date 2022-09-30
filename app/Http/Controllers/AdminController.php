<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function index(){
        $data=[
            'users'=>500,
        ];
        return Inertia::render('Admin',compact('data'));
    }
}
