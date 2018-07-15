<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request; 

use App\User;

class UsersController extends Controller{

    public function index(){
        $user = User::all();
        if($user){
            $response['error'] = false;
            $response['message'] = $user;
        }else{
            $response['error'] = true;
            $response['message'] = 'Users Lists is Empty';
        }
        return response()->json($response);
    }

    public function show($id){
        $user = User::find($id);
        if($user){
            $response['error'] = false;
            $response['message'] = $user;
        }else{
            $response['error'] = true;
            $response['message'] = 'No Users Found!';
        }
        return response()->json($response);
    }

    public function login(Request $request){
        $user = User::where('username', $request['username'])->first();
        if($user){
            If(Hash::check($request['password'], $user->password)){
                $response['error'] = false;
                $response['message'] = "Login Successfully!";
            }else{
                $response['error'] = true;
                $response['message'] = "Username and password does not match";
            }
        }else{
            $response['error'] = true;
            $response['message'] = 'Account is not registered';
        }

        return response()->json($response);
    }

    public function store(Request $request){
        $request['api_token'] = strtoupper(str_random(60));
        $request['password'] = Hash::make($request['password']);
        $user = User::create($request->all());

        $response['error'] = false;
        $response['message'] = 'Account Registration Sucessfull!';
        return response()->json($user);
    }

    public function update(Request $request, $id){
        $user = User::find($id);
        $user->password = (Hash::make($request['password']));
        $response['error'] = $user->save();
        if($response['error'])
            $response['message'] = 'Password Successfully Changed!';
        else
            $response['message'] = 'Fail Password Change!';

        return response()->json($response);
    }

    public function delete($id){
        if($user = User::find($id)){
            $response['error'] = $user->delete();
            $response['message'] = 'User Successfully Deleted!';
        }else{
            $response['error'] = false;
            $response['message'] = 'No user found';
        }

        return response()->json($response);
    }
}