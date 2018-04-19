<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 4/12/2018
 * Time: 1:36 PM
 */

namespace App\Models;


use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class Employee extends Model implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'birthday',
        'gender',
        'mobile',
        'address',
        'marital_status',
        'startwork_date',
        'endwork_date',
        'curriculum_vitae',
        'is_employee',
        'company',
        'avatar',
        'teams_id',
        'roles_id',
        'employee_type_id'
    ];


    protected $hidden = [
        'password',
    ];

    public function teams(){
        return $this->belongsTo('App\Models\Team');
    }
    public function roles(){
        return $this->belongsTo('App\Models\Role');
    }
    public function employeeType(){
        return $this->belongsTo('App\Models\EmployeeType');
    }
    public function processes(){
        return $this->hasMany('App\Models\Process');
    }
    public function projects(){
        return $this->belongsToMany('App\Models\Project', 'processes', 'employee_id', 'projects_id')
                    ->withPivot('id', 'man_power', 'start_date', 'end_date', 'employee_id', 'projects_id', 'role_id');
    }
}