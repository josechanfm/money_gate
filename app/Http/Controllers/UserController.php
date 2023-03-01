<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class UserController extends Controller
{
    public function index(){

        $users = User::with('roles')->orderBy('id','DESC')->get();

        return Inertia::render('User/List',compact('users'));
    }

    public function create(){
        $users = User::orderBy('id','DESC')->get();

        return Inertia::render('User/List',compact('users'));

    }
}
