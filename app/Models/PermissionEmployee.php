<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PermissionEmployee extends Model
{
    public $table = 'permission_employee';
    protected $fillable = ['permission_id', 'employee_id'];

    public function permission_employee(){
    	$id_employee=Auth::user()->id;
        $arr_permission=PermissionEmployee::where('employee_id',$id_employee)->get();
    	return $arr_permission;
    }

}
