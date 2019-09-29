<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class AuthController extends Controller
{

    public function loginPost(Request $request){
//        return Response::json([
//            'user'=> $request->input(),
//            'successs' => false
//        ], 400);

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){

            return Response::json([
                'user'=> Auth::user(),
                'message' => "Logged in!",
                'status' => 'success'
            ], 200);
            //error code 200 = OK

        }
        else{

            return Response::json([
                'message' => "Emaili ose fjalkalimi gabim!",
                'status' => 'error'
            ], 400);
            //error code 400 = Bad Request ~ wrong email or password

        }
    }

    public function checkAuth(){
        if(Auth::check()){
            return \Response::json([
                'user' => Auth::user(),
                'message' => "Logged in!",
                'status' => "success"
            ], 200);
            //error code 200 = OK

        }
        else{
            return \Response::json([
                'message' => "Not logged in!",
                'status' => "error"
            ], 401 );
            //error code 401 = Unauthorised
        }

    }

}
