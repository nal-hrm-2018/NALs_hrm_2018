<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
class Role extends Model
{
	use Authenticatable, Authorizable, CanResetPassword;
    protected $table = 'roles';
    protected $fillable = [
        'name','description','updated_at','last_updated_by_employee','created_at','created_by_employee','delete_flag'
    ];
}
