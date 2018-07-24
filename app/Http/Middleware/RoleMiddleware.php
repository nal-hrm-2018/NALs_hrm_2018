<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
        $arr_permission=DB::table('permission_employee')->select('permission_id')->where('employee_id',$id_employee)->get()->toArray();
        $cout=0;
        foreach ($arr_permission as $key => $value) {
            $name_permission=DB::table('permissions')->select('name')->where('id',$value->permission_id)->get()->toArray();
            foreach ($name_permission as $key => $value) {
                $namee=$value->name;
            }
            if($role==$namee){
                $cout=1;
                return $next($request);
            }
        }
        if($cout==0){
            $message = "Bạn không được phép vào chức năng này.";
            echo "<script type='text/javascript'>alert('$message');</script>";
            return response()->view('admin.module.index.index');
        }
    }
}
