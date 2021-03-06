<?php

namespace App\Models;


use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
class Team extends Model
{
	use Authenticatable, Authorizable, CanResetPassword;
    protected $table = 'teams';
    protected $fillable = [
        'id','name','description','updated_at','last_updated_by_employee','created_at','created_by_employee','delete_flag'
    ];

    public function employees(){
        return $this->belongsToMany('App\Models\Employee', 'employee_team', 'team_id', 'employee_id');
    }
}
