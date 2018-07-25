<?php
namespace App\Http\Controllers\API;



use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User;

use JWTAuth;
use JWTAuthException;
use Hash;

abstract class BaseAPIController extends Controller
{
    const SUCCESS_CODE = '200';
    function sendSuccess($data, $message = 'null'){
        return response()->json([
            'result_code' => self::SUCCESS_CODE,
            'result_message' => $message,
            'data' => $data
        ]);
    }

    function sendError($errorCode, $message, $data){
        return response()->json([
            'result_code' => $errorCode,
            'result_message' => $message,
            'data' => $data
        ]);
    }
}