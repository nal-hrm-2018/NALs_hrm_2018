<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\PermissionEmployee;
use App\Models\Permissions;

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
        $id_employee=Auth::user()->id;
        $arr_permission=PermissionEmployee::where('employee_id',$id_employee)->get();
        $cout=0;
        foreach ($arr_permission as $key => $value) {
            $name_permission=Permissions::where('id',$value->permission_id)->get();
            foreach ($name_permission as $key => $value) {
                $namee=$value->name;
            }
            if($role==$namee){
                $cout=1;
                return $next($request);
            }
        }
    }
}
