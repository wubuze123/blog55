<?php
namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class Passport extends Controller {

    public function index()
    {
        return 'Api/Home/index';
    }

/*  passport 教程
https://laravel-china.org/articles/10188/laravel-55-uses-passport-services-to-do-api-authentication
  */
    /**
     * @param Request $request
     * name
     * email
     * password
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['name'] =  $user->name;

        return response()->json(['success'=>$success], 200);
    }

    public function login(){

        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')->accessToken;
            return response()->json(['success' => $success], 200);
        }
        else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }

    public function getUser(Request $request)
    {
        // $user = Auth::guard('api')->user();
        $user = $request->user();
        return response()->json(['success' => $user], 200);
    }

}