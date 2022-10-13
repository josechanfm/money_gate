<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\AccessToken;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;


class AccessTokenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = AccessToken::all();
        return Inertia::render('AccessToken',['data'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $username=$request->name;
        $credential=[
            'email'=>$request->email,
            'password'=>$request->password,
        ];
        $user=User::where('email',$credential['email'])->first();
        if($user){
            return redirect()->back()
                ->with('message', 'Email of the user already exists, Token Creation fail!'.json_encode($user));
        }else{
            $user=new \App\Models\User();
            $user->name=$username;
            $user->email=$credential['email'];
            $user->password=Hash::make($credential['password']);
            $user->save();
            
            $adminToken = $user->createToken('Admin-token',['create','update','delete']);
            $updateToken = $user->createToken('Update-token',['create','update']);
            $basicToken = $user->createToken('Basic-token',['none']);

            $tokens=[
                'admin'=>$adminToken->plainTextToken,
                'update'=>$updateToken->plainTextToken,
                'basic'=>$basicToken->plainTextToken,
            ];
            return redirect()->back()
                ->with('message', json_encode($tokens));
        }
    }

/**
* {
*	"admin": "7|tg3xpr2iyrGr8cXS2C15okxA2InkkZ8aE18Po809",
*	"update": "8|HihiMGnA0ag2lf8GT9gd79BMbT9oMRSmzITcYKTk",
*	"basic": "9|kP7bpEZzrHZ9NRYGB9s1rOf6BqwfO9r4TjwpqFn2"
*}
 **/    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function test(){
        return response('Hello World');
    }

}
