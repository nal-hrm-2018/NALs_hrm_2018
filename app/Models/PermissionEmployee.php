<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PermissionEmployee extends Model
{
    public $table = 'permission_employee';
    protected $fillable = ['permission_id', 'employee_id'];

    public $timestamps = false;

    public function permission_employee($id){
        $arr_permission=PermissionEmployee::where('employee_id',$id)->get();
    	return $arr_permission;
    }

}
