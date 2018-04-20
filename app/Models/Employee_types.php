<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
class Employee_types extends Model
{
	use Authenticatable, Authorizable, CanResetPassword;
    protected $table = 'employee_types';
    protected $fillable = [
        'name','description','updated_at','last_updated_by_employee','created_at','created_by_employee','delete_flag'
    ];

    public function employee()
    {
        return $this->hasMany(\App\Models\Employee::class , 'employee_type_id', 'id');
    }

    public function scopeName($query, $name)
    {
        return $query->where('name', $name);
    }

}
