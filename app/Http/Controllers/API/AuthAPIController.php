<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use App\User;

use JWTAuth;
use JWTAuthException;
use Hash;

class AuthAPIController extends BaseAPIController
{
    private $user;

    public function __construct(User $user){
        $this->user = $user;
    }

//    public function register(Request $request){
//        $user = $this->user->create([
//            'name' => $request->get('name'),
//            'email' => $request->get('email'),
//            'password' => Hash::make($request->get('password'))
//        ]);
//        return $this->sendSuccess(200, $user, 'User created successfully');
//    }

    public function login(Request $request){
        $credentials = $request->only('email', 'password');
        $token = null;
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return $this->sendError(401, 'invalid_email_or_password');
            }
        } catch (JWTAuthException $e) {
            return $this->sendError(500, 'failed_to_create_token');
        }
        return $this->sendSuccess($token, 'Login success!');
    }
}
