<?php

namespace App\Http\Middleware;

use App\Exceptions\TokenInvalidException;
use Closure;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class VerifyJWTToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::toUser($request->header('token'));
        }catch (JWTException $e) {
            throw new TokenInvalidException();
        }
        return $next($request);
    }
}