<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

    public function login(Request $request){
        $credentials = $request->only(['email','password']);

        $token = auth('api')->attempt($credentials);
        if($token){
            $user = auth('api')->user();

            $success = true;

            return compact('success','user','token');
        } else{
            $success = false;
            $message = 'Invalid credentials';

            return compact('success','message');
        }
    }

    public function logout(){
        auth('api')->logout();
        $success = true;
        $message = 'Logout correct';

        return compact('success','message');
    }
}
