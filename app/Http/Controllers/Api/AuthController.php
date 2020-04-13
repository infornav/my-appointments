<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\ValidateAndCreatePatient;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use ValidateAndCreatePatient;

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

        $jwt = auth('api')->attempt($credentials);
        if($jwt){
            $user = auth('api')->user();

            $success = true;

            return compact('success','user','jwt');
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

    public function register(Request $request){
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $jwt = auth('api')->login($user);
        $success = true;

        return compact('success','user','jwt');
    }
}
