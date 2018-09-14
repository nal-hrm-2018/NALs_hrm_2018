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
use App\Models\Holiday;
use App\Models\HolidayDefault;
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
    public function count_invalid_date(Absence $absence){
        $calculated = []; // mảng lưu số ngày không hợp lệ
        // tổng số ngày trong đơn ( chưa trừ ngày nghỉ, ngày lễ)
        // dd( date('Y-m-d', strtotime($absence->from_date)) );

        if( date('m', strtotime($absence->to_date)) == date('m', strtotime($absence->from_date)) ){
            $count_day = 1+(int)date_create($absence->to_date)->format('d') - (int)date_create($absence->from_date)->format('d'); 
        } else {
            // $end = (int) date('t', strtotime($absence->from_date)); //get end date of month            
            $count_day_start_month = 1+(int)date('t', strtotime($absence->from_date)) - (int)date_create($absence->from_date)->format('d');
            $count_day_end_month = (int)date_create($absence->to_date)->format('d'); 
            $count_day = $count_day_start_month + $count_day_end_month;
            // kiểm tra có phải 2 tháng liên tiếp, nếu không, $count_day+= số ngày các tháng ở giữa
            $check_month = (int)date_create($absence->from_date)->format('n'); 
            $end_month = (int)date_create($absence->to_date)->format('n'); 
            $year = (int) date('Y', strtotime($absence->from_date));
            while ( $end_month -$check_month -1) {
                $check_month ++;
                $coun_day_check_month = cal_days_in_month(CAL_GREGORIAN, $check_month, $year);
                $count_day += $coun_day_check_month;
            }
        }
        if($absence->absenceType->name <> 'maternity_leave' ){
            $date = $absence->from_date ;
            while ( $date <= $absence->to_date) {
                if( ( date_create($date)->format('l') == 'Sunday') || ( date_create($date)->format('l') == 'Saturday') ){
                    $count_day--;
                    $calculated = array_prepend($calculated, $date); 
                }
                $date = date('Y-m-d', strtotime("+1 day", strtotime($date)));
            }
            $date = $absence->from_date ;
            
            while ( $date <= $absence->to_date) {
                //kiểm tra co phải ngày nghĩ lễ không.
                $holiday = HolidayDefault::all();
                $sttHoliday = 0 ;
                foreach ($holiday as $holiday){
                    if( date_format($holiday->date,"m-d") == date('m-d', strtotime($date)) ){
                        $sttHoliday = 1;
                        break;
                    }
                }
                //Kiểm tra co phải ngày nghĩ lễ đột xuất k
                if ($sttHoliday == 0 ){
                    $holiday = Holiday::all();
                    foreach ($holiday as $holiday){
                        if( date_format($holiday->date,"Y-m-d") == date('Y-m-d', strtotime($date)) ){
                            $sttHoliday = 1;
                            break;
                        }
                    }
                }
                // Kiểm tra ngày lễ có trùng ngày nghỉ (Saturday ỏ Sunday)
                if($sttHoliday == 1){
                    if(in_array($date, $calculated) == false){
                        $count_day--;
                        $calculated = array_prepend($calculated, $date); 
                    }
                }
                 $date = date('Y-m-d', strtotime("+1 day", strtotime($date)));
            }
        } 
        if(($absence->absenceTime->name <> 'all')){
            $count_day /=2;
        }          
        return $count_day;
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

        $objModel = new Employee();
        $absences = Absence::where('employee_id', $id)
                            ->whereYear("from_date", date('Y'))
                            ->where('delete_flag',0)
                            ->get();
        foreach($absences as $absence){  
            switch ($absence->absenceType->name) {
                case 'annual_leave':
                    $count_day = $objModel->count_invalid_date($absence);
                    $annual_leave += $count_day;
                    break;
                case 'unpaid_leave':
                    $count_day = $objModel->count_invalid_date($absence);
                    $unpaid_leave += $count_day;
                    // dd($unpaid_leave);
                    break;
                case 'maternity_leave':
                     $count_day = $objModel->count_invalid_date($absence);
                    $maternity_leave += $count_day;
                    break;
                case 'marriage_leave':
                    $count_day = $objModel->count_invalid_date($absence);
                    $marriage_leave += $count_day;
                    break;
                case 'bereavement_leave':
                    $count_day = $objModel->count_invalid_date($absence);
                    $bereavement_leave += $count_day;
                    break;
                case 'sick_leave':
                    $count_day = $objModel->count_invalid_date($absence);
                    $sick_leave += $count_day;
                    break;                
                default: 
                    dd('fail');
                    break;
            }            
        };
        if(date('n')<7){
             if($annual_leave > ($pemission_annual_leave + $remaining_last_year)) {
                $remaining_this_year = 0;
                $unpaid_leave += ($annual_leave - ($pemission_annual_leave + $remaining_last_year));
             } else{
                 $remaining_this_year = ($pemission_annual_leave + $remaining_last_year) - $annual_leave;
             }
             if($annual_leave > $remaining_last_year){
                $remaining_last_year = 0;
             } else{
                $remaining_last_year -= $annual_leave ;
             }
        } else{
            $half_year = Absence::whereMonth('from_date','<', '7')
                        ->where('delete_flag',0)
                        ->whereHas('absenceType', function($query){
                            $query->where('name',  'annual_leave');
                        })
                        ->get();   // lấy ngày nghỉ phép năm trước tháng 7
            if( count($half_year) >= $remaining_last_year){
                if($annual_leave > ($pemission_annual_leave + $remaining_last_year)) {
                    $remaining_this_year = 0;
                    $unpaid_leave += ($annual_leave - ($pemission_annual_leave + $remaining_last_year));
                 } else{
                     $remaining_this_year = ($pemission_annual_leave + $remaining_last_year) - $annual_leave;
                 }
            } else {
                if($annual_leave > ($pemission_annual_leave + count($half_year))){
                    $remaining_this_year = 0;
                    $unpaid_leave += ($annual_leave - ($pemission_annual_leave + count($half_year)));
                } else {

                    $remaining_this_year = ($pemission_annual_leave +  count($half_year)) - $annual_leave;

                }
            }
            $remaining_last_year = 0;
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
