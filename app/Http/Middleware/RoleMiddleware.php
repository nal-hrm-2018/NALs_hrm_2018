<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\PermissionEmployee;
use App\Exceptions\PermissionException; 

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$role)
    {
        if(Auth::user()->hasPermission($role)){
            return $next($request);
        }
        throw new PermissionException('Bạn không có quyên vao chức năng này');
    }
}
