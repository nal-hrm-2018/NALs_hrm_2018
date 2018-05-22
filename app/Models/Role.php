<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;



class Role extends Model
{
    use Authenticatable, Authorizable, CanResetPassword;
    protected $table = 'roles';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'name', 'description', 'updated_at', 'last_updated_by_employee', 'created_at', 'created_by_employee', 'delete_flag'
    ];

    public function employees()
    {
        return $this->hasMany('App\Models\Employee', 'role_id')->where('delete_flag', '=', 0);
    }

    public function processes()
    {
        return $this->hasMany('App\Models\Process','role_id')->where('delete_flag', '=', 0);
    }

}
