<?php
namespace App\Http\Controllers\API;



use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User;

use JWTAuth;
use JWTAuthException;
use Hash;

class BaseAPIController extends Controller
{
    private $user;

    function sendSuccess($data, $message = 'null'){
        return response()->json([
            'result_message' => $message,
            'data' => $data
        ]);
    }

    function sendError($errorCode, $message, $data){
        return response()->json([
            'error_code' => $errorCode,
            'result_message' => $message,
            'data' => $data
        ]);
    }

    public function __construct(User $user){
        $this->user = $user;
    }

    public function register(Request $request){
        $user = $this->user->create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password'))
        ]);

//        return response()->json([
//            'status'=> 200,
//            'message'=> 'User created successfully',
//            'data'=>$user
//        ]);
        return $this->sendSuccess($user, 'User created successfully');
    }

    public function login(Request $request){
        $credentials = $request->only('email', 'password');
        $token = null;
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
//                return response()->json(['invalid_email_or_password'], 422);
                return $this->sendError(422, 'invalid_email_or_password\'');
            }
        } catch (JWTAuthException $e) {
//            return response()->json(['failed_to_create_token'], 500);
            return $this->sendError(500, 'failed_to_create_token');
        }
//        return response()->json(compact('token'));
        return $this->sendSuccess($token, 'Login success!');
    }
}