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
use App\Models\PermissionEmployee;
use App\Models\Permissions;
use Illuminate\Support\Facades\DB;


class Employee extends Model implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;
    protected $table = 'employees';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'email',
        'password',
        'remember_token',
        'name',
        'birthday',
        'gender',
        'mobile',
        'address',
        'marital_status',
        'work_status',
        'startwork_date',
        'endwork_date',
        'curriculum_vitae',
        'is_employee',
        'company',
        'avatar',
        'employee_type_id',
        'team_id',
        'role_id',
        'is_manager',
        'salary_id',
        'updated_at',
        'last_updated_by_employee',
        'created_at',
        'created_by_employee',
        'delete_flag'
    ];


    protected $hidden = [
        'password', 'remember_token'
    ];

    public function employeeType()
    {
        return $this->belongsTo('App\Models\EmployeeType', 'employee_type_id');

    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function performances()
    {
        return $this->hasMany('App\Models\Performance', 'employee_id')->where('delete_flag', '=', 0);
    }

    public function extraAbsenceDates()
    {
        return $this->hasMany('App\Models\ExtraAbsenceDate', 'employee_id')->where('delete_flag', '=', 0);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany('App\Models\Permissions', 'permission_employee', 'employee_id', 'permission_id');
        
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function processes()
    {
        return $this->hasMany('App\Models\Process')->where('delete_flag', '=', 0);
    }

     public function teams()
    {
        return $this->belongsToMany('App\Models\Team', 'employee_team', 'employee_id', 'team_id');
    }

    public function role()
    {
        return $this->belongsTo('App\Models\Role', 'role_id');
    }

    public function projects()
    {
        return $this->belongsToMany('App\Models\Project', 'processes', 'employee_id', 'project_id')
            ->withPivot('id', 'man_power', 'start_date', 'end_date', 'employee_id', 'project_id', 'role_id');
    }

    public function roles(){
        return $this->belongsToMany('App\Models\Role', 'processes', 'employee_id', 'role_id');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function absences()
    {
        return $this->hasMany('App\Models\Absence')->where('delete_flag', '=', 0);
    }
    public function confirms()
    {
        return $this->hasMany('App\Models\Confirm')->where('delete_flag', '=', 0);
    }
    public function hasPermission($role){
        $status_emp_per = $this->whereHas('permissions',function($query) use ($role){
            $query->where('name',$role);
        })->where('id',$this->id)->get();

        if(count($status_emp_per)>0)
            return true;
        return false;
    }
    public function hasRoleHR(){
        $status_emp_per = $this->whereHas('role',function($query) {
            $query->where('name','HR');
        })->where('id',$this->id)->get();

        if(count($status_emp_per)>0)
            return true;
        return false;
    }

}
