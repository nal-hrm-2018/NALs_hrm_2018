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
use DateTime;
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
    public function teams(){
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
    public function overtime()
    {
        return $this->hasMany('App\Models\Overtime')->where('delete_flag', '=', 0);
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
    public function hasRole($role){
        $status_emp_role = $this->whereHas('role',function($query) use ($role){
            $query->where('name',$role);
        })->where('id',$this->id)->get();

        if(count($status_emp_role)>0)
            return true;
        return false;
    }
    public static function emp_absence($id)
    {
        
        $objEmployee = Employee::find($id);
        $startwork_year = (int)date_create($objEmployee->startwork_date)->format("Y");
        if($startwork_year == date('Y')){
            $startwork_month = (int)date_create($objEmployee->startwork_date)->format("n");
            $pemission_annual_leave = 12 - $startwork_month;
        } elseif ( ((int)date('Y') - $startwork_year) < 6 ) {
            $pemission_annual_leave =12;
        } else {
            switch ($startwork_year) {
                case '6':
                    $pemission_annual_leave =12;
                    break;
                case '7':
                    $pemission_annual_leave =13;
                    break;
                case '8':
                    $pemission_annual_leave =14;
                    break;               
                default:
                    $pemission_annual_leave =15;
                    break;
            }
        }

        $remaining_last_year = $objEmployee->remaining_absence_days;

        $annual_leave = 0;
        $unpaid_leave = 0;
        $maternity_leave = 0;
        $marriage_leave = 0;
        $bereavement_leave =0;
        $sick_leave =0;

        foreach($objEmployee->absences as $absence){           
            switch ($absence->absenceType->name) {
                case 'annual_leave':
                     $count_day = 1+(int)date_create($absence->to_date)->format('d') - (int)date_create($absence->from_date)->format('d');                
                    $annual_leave += $count_day;
                    break;
                case 'unpaid_leave':
                     $count_day = 1+ (int)date_create($absence->to_date)->format('d') - (int)date_create($absence->from_date)->format('d');
                    $unpaid_leave += $count_day;
                    // dd($unpaid_leave);
                    break;
                case 'maternity_leave':
                     $count_day = 1+ (int)date_create($absence->to_date)->format('d') - (int)date_create($absence->from_date)->format('d');
                    $maternity_leave += $count_day;
                    break;
                case 'marriage_leave':
                     $count_day = 1+ (int)date_create($absence->to_date)->format('d') - (int)date_create($absence->from_date)->format('d');
                    $marriage_leave += $count_day;
                    break;
                case 'bereavement_leave':
                     $count_day = 1+ (int)date_create($absence->to_date)->format('d') - (int)date_create($absence->from_date)->format('d');
                    $bereavement_leave += $count_day;
                    break;
                case 'sick_leave':
                     $count_day = 1+ (int)date_create($absence->to_date)->format('d') - (int)date_create($absence->from_date)->format('d');
                    $sick_leave += $count_day;
                    break;
                
                default: 
                    dd('fail');
                    break;
            }
            
        };
        if($annual_leave > ($pemission_annual_leave + $remaining_last_year)) {
            $remaining_this_year = 0;
            $unpaid_leave += ($annual_leave - ($pemission_annual_leave + $remaining_last_year));
         } else{
             $remaining_this_year = ($pemission_annual_leave + $remaining_last_year) - $annual_leave;
         }

        $absences = [
            "pemission_annual_leave" => $pemission_annual_leave, //số ngày được phép năm nay
            "remaining_last_year" => $remaining_last_year, //số ngày còn lại từ năm trước
            "remaining_this_year" => $remaining_this_year, //số ngày phép năm nay còn lại
            "annual_leave" => $annual_leave, //số ngày nghỉ phép năm
            "unpaid_leave" => $unpaid_leave, //số ngày nghỉ không lương
            "maternity_leave" => $maternity_leave, //nghỉ thai sản
            "marriage_leave" => $marriage_leave, // nghỉ cưới hỏi
            "bereavement_leave" => $bereavement_leave, // nghỉ tang chế
            "sick_leave" => $sick_leave, //nghỉ ốm
        ];
        
        // dd($absences); die();

        return $absences;
    }

}
