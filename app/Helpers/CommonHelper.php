<?php

use App\Http\Requests\ProcessAddRequest;
use Illuminate\Support\Facades\Validator;
use App\Models\Employee;
use App\Models\Role;
use App\Models\Confirm;
use Carbon\Carbon;
use Illuminate\Support\MessageBag;
use App\Models\AbsenceType;
use App\Models\AbsenceStatus;

function test()
{
    return "test helper";
}

function getProjectStatus($project)
{
    if (isset($project->status)) {
        return $project->status->name;
    }
    return '';
}

function getArrayMonth(){
   return $array=[
        1=>trans('common.month.january'),
        2=>trans('common.month.february'),
        3=>trans('common.month.march'),
        4=>trans('common.month.april'),
        5=>trans('common.month.may'),
        6=>trans('common.month.june'),
        7=>trans('common.month.july'),
        8=>trans('common.month.august'),
        9=>trans('common.month.september'),
        10=>trans('common.month.october'),
        11=>trans('common.month.november'),
        12=>trans('common.month.december'),
    ];
}

function getAbsenceStatuses($status)
{
   $status =  AbsenceStatus::select()->where('name',$status)->first();
   if(empty($status)){
    return '';
   }else{
    return $status->id;
   }
}

function getAbsenceType($type)
{
  $type = AbsenceType::select()->where('name',$type)->first();
   if(empty($type)){
    return '';
   }else{
//       dd($type);
    return $type->id;
   }
}

function getArraySelectOption()
{
    $array = ['20' => '20', '50' => '50', '100' => '100'];

    return $array;
}

function array_has_dupes($array)
{
    return count($array) !== count(array_flip($array));
}

function getRoleofVendor($vendor)
{
    $text = "";
    $arr_roles = array_unique($vendor->roles()->pluck('name')->toArray());
    if (!empty($processes)) {
        foreach ($arr_roles as $key => $value) {
            if ($key === count($arr_roles) - 1) {
                $text = $text . $value;
            } else {
                $text = $text . $value . ",";
            }
        }
    }
    return $text;
}

function getTotalManPowerofProcesses($processes)
{
    $total = 0;
    if (!empty($processes)) {
        foreach ($processes as $item) {
            $total = $total + $item->man_power;
        }
    }
    return $total;
}

function getArrayManPower()
{
    return [0.125, 0.25, 0.5, 0.75, 1];
}

function hasDupeProject($processes, $start_date_process, $end_date_process, $key, $value, $employee_name_selected)
{
    $start_date_process_selected = Carbon::parse($start_date_process);
    $end_date_process_selected = Carbon::parse($end_date_process);
    $count = 0;
    if (!empty($processes)) {
        foreach ($processes as $process) {
            if (!is_null($process['delete_flag']) && $process['delete_flag'] !== '0') {
                continue;
            }

            if ($process[$key] === $value) {
                $start_date_process = Carbon::parse($process['start_date_process']);
                $end_date_process = Carbon::parse($process['end_date_process']);
                if ($start_date_process->gte($end_date_process_selected) || $start_date_process_selected->gte($end_date_process)) {
                    continue;
                }
                $count++;
                if ($count > 1) {
                    if ($key === 'employee_id') {
                        $string_error = trans('validation.custom.employee.error_duplicate_member',[
                            'employee_name_selected'=>$employee_name_selected,
                            'value'=>$value,
                            'start_date_process'=>date('d/m/Y', strtotime($process['start_date_process'])),
                            'end_date_process'=>date('d/m/Y', strtotime($process['end_date_process']))
                        ]);
                        return $string_error;
                    }
                    if ($key === 'role_id') {
                        $employee_name = Employee::select('name')->where('id', $process['employee_id'])->first();
                        if (!is_null($employee_name)) {
                            $employee_name = $employee_name->name;
                        } else {
                            $employee_name = '';
                        }
                        $string_error = trans('validation.custom.role.error_P0_process',[
                            'employee_name_selected'=>$employee_name_selected,
                            'start_date_process'=>date('d/m/Y', strtotime($process['start_date_process'])),
                            'end_date_process'=>date('d/m/Y', strtotime($process['end_date_process'])),
                            'employee_name'=>$employee_name
                        ]);
                        return $string_error;
                    }
                }
            }
        }
        return false;
    }
    return false;
}

function checkValidProjectData()
{
    // ham nay sinh ra de chong lai tinh trang thay doi thong tin project sau khi da add process
    $processes = request()->get('processes');
    $processAddRequest = new ProcessAddRequest();
    $error_messages = array();
    if (!empty($processes)) {
        //validate cac process
        foreach ($processes as $key => $process) {
            $validator = Validator::make(
                $process,
                $processAddRequest->ruleReValidate(
                    \request()->get('estimate_start_date'),
                    \request()->get('estimate_end_date'),
                    \request()->get('start_date_project'),
                    \request()->get('end_date_project'),
                    request()->get('project_id'),
                    $process,
                    $processes
                ),
                $processAddRequest->messages()
            );
            if ($validator->fails()) {
                // key = id  process , value = messagebag of validate
                $error_messages[$key] = [];
                $error_messages[$key]['errors']  = $validator->messages();
                $error_messages[$key]['available_processes']=request()->get('available_processes');
            }
        }
        if (!empty($error_messages)) {
            session()->flash('error_messages', $error_messages);
            return false;
        }
    }
    return true;
}

function getEmployee($id)
{
    return Employee::find($id);
}

function getRole($id)
{
    return Role::where('delete_flag', '=', 0)->find($id);
}

function getIdEmployeefromProcessError($data)
{
    if (!empty($data)) {
        $rs = explode('_', $data, 2);
        return $rs[0];
    }
    return '';
}

function showListAvailableProcesses($available_processes)
{
    $string_available_processes = '';
    foreach ($available_processes as $process) {
        $string_available_processes = $string_available_processes .
            " ".trans('project.id').": " . $process['project_id'] . ", ".
            " ".trans('project.man_power').": " . $process['man_power'] .", ".
            " ".trans('project.process_start_date').": " . date('d/m/Y', strtotime($process['start_date'])) .", ".
            " ".trans('project.process_end_date').": " . date('d/m/Y', strtotime($process['start_date'])) . "\n";
    }

    return nl2br (trans('validation.custom.man_power.available_processes')." : \n" . $string_available_processes);
}

function getInformationDataTable($pagination)
{
    return trans('project.data_table.information',[
        'first_item'=>$pagination->firstItem(),
        'last_item'=>$pagination->lastItem(),
        'total'=>$pagination->total()
    ]);

}

function checkPOinProject($processes)
{
    $id_po = Role::select('id')->where('delete_flag', 0)->where('name', '=', config('settings.Roles.PO'))->first();
    if (!is_null($id_po)) {
        $id_po = (string)Role::select('id')->where('delete_flag', 0)->where('name', '=', config('settings.Roles.PO'))->first()->id;
    } else {
        $bag = new MessageBag();
        $bag->add('error_role', "Role PO not exist in database");
        session()->flash('errors', $bag);
        return false;
    }
    foreach ($processes as $key => $process) {
        if($process['delete_flag']==='1'){
            continue;
        }
        if ($process['role_id'] === $id_po) {
            return true;
        }
    }
    return false;
}
function selectConfirm($id_absence){
    $listConfirm = Confirm::select('*', 'employees.name AS nameEmployee', 'confirms.reason AS reasonAbsence')
            ->join('employees', 'employees.id', '=', 'confirms.employee_id')
            ->join('absence_statuses', 'absence_statuses.id', '=', 'confirms.absence_status_id')
            ->where('confirms.absence_id',$id_absence)
            ->where('confirms.delete_flag',0)
            ->where('confirms.absence_status_id',2)
            ->get();
    return $listConfirm;
}
function selectConfirmByID(){
    $id = Auth::user()->id;
    $listConfirm = Confirm::select('*', 'employees.name AS nameEmployee', 'confirms.reason AS reasonAbsence')
            ->join('employees', 'employees.id', '=', 'confirms.employee_id')
            ->join('absence_statuses', 'absence_statuses.id', '=', 'confirms.absence_status_id')
            ->join('absences', 'absences.id', '=', 'confirms.absence_id')
            ->where('confirms.delete_flag',0)
            ->where('absences.employee_id',$id)
            ->where('confirms.absence_status_id',2)
            ->get();
    return $listConfirm;
}

function getRemainingDate($dayoff,$total){

    if (($total - $dayoff) < 0) {
        return 0;
    } else {
        return $total - $dayoff;
    }
}

// kiem tra ngay het han hop dong
function checkExpiredPolicy($employee_id , $year ,$month){
    $employee = Employee::find($employee_id);
    $expiry= Carbon::parse($employee->endwork_date);
    $expiry_year = $expiry->year;
    $expiry_month = $expiry->month;

    if((int)$year>(int)$expiry_year){
        return true;
    }elseif((int)$year===(int)$expiry_year){
        if(!empty($month) && $month>=$expiry_month){
            return true;
        }
    }
    return false;
}

function displayNumberAbsenceRedundancyByYear($numberAbsenceRedundancyOfYearOld,$numberDaysOffFromTo,$month){
    if(empty($month)){
        return $numberAbsenceRedundancyOfYearOld;
    }else{
        if($month<7){
            if($numberAbsenceRedundancyOfYearOld-$numberDaysOffFromTo>0){
                return $numberAbsenceRedundancyOfYearOld-$numberDaysOffFromTo;
            }else{
                return 0;
            }
        }else{
            return 0;
        }
    }
}

function getJsonObjectAbsenceHrList($employees,$absenceService){
    $object = [];
    foreach($employees as $employee){
        //list tat ca don nghi cua 1 employee ( chon thang -> tra ve don nghi trong thang do , chon nam tra ve don nghi trong nam do)
        $listAbsence=$absenceService->getListNumberOfDaysOff(
            $employee->id,empty(request()->get('year_absence'))?date('Y'):request()->get('year_absence'),
            empty(request()->get('month_absence'))?null:request()->get('month_absence'),
            getAbsenceStatuses(config('settings.status_common.absence.accepted'))
        );
        // so ngay nghi du nam ngoai
        $numberAbsenceRedundancyOfYearOld=$absenceService->getnumberAbsenceRedundancyByYear(
            $employee->id,
            empty(request()->get('year_absence'))?((int)date('Y')-1):((int)request()->get('year_absence')-1)
        );
        // so ngay nghi tu ngay bat dau hop dong den ngay input (neu thang nhap vao = null thi tra ve null )
        $numberDaysOffFromTo= $absenceService->getNumberDaysOffFromTo(
            $employee,
            empty(request()->get('month_absence'))?null:request()->get('month_absence'),
            empty(request()->get('year_absence'))?date('Y'):request()->get('year_absence'),
            getAbsenceType(config('settings.status_common.absence_type.salary_date')),
            getAbsenceStatuses(config('settings.status_common.absence.accepted'))
        );
        //tong ngay nghi truoc thang 7 (lay tu ngay bat dau hop dong den thang 7)
        $numberOfDaysOffBeforeJuly = $absenceService->getNumberDaysOffFromTo(
            $employee,
            7,
            empty(request()->get('year_absence'))?date('Y'):request()->get('year_absence'),
            getAbsenceType(config('settings.status_common.absence_type.salary_date')),
            getAbsenceStatuses(config('settings.status_common.absence.accepted'))
        );
        // tong so ngay duoc nghi cua employee ( neu thang = null >> tra ve tong ngay duoc nghi trong nam , thang != null tra ve tong ngay duoc nghi tu stat den thang input)
        $totalDateAbsences=$absenceService->totalDateAbsences(
            $employee,
            empty(request()->get('year_absence'))?date('Y'):request()->get('year_absence'),
            empty(request()->get('month_absence'))?null:request()->get('month_absence'),
            $numberAbsenceRedundancyOfYearOld,
            $numberDaysOffFromTo,
            $numberOfDaysOffBeforeJuly
        );
        // tong ngay nghi co dinh cua employee trong 1 nam (tong ngay nghi cua ca nam cua 1 employee)
        $totalDefaultDateAbsences = $absenceService->absenceDateOnYear(
                $employee->id,
                empty(request()->get('year_absence')) ? date('Y') : request()->get('year_absence')) +
            $absenceService->numberAbsenceAddPerennial
            (
                $employee->id,
                empty(request()->get('year_absence')) ? date('Y') : request()->get('year_absence')
            );

        // tong ngay da nghi phep cua employee (thang = null tong ngay da nghi ca nam , thang != nul tong ngay da nghi tu stat den thang input)
        $salaryDaysOff = $absenceService->numberOfDaysOff(
            $listAbsence,
            empty(request()->get('year_absence')) ? date('Y') : request()->get('year_absence'),
            empty(request()->get('month_absence')) ? null : request()->get('month_absence'),
            getAbsenceType(config('settings.status_common.absence_type.salary_date'))
        );

        //------------------
        $item = [];
        $item['id']=isset($employee->id)? $employee->id: "";
        $item[trans('common.name.employee_name')]=isset($employee->name)? $employee->name: "-";
        $item[trans('employee.profile_info.email')]=isset($employee->name)? $employee->email: "-";
        $item[trans('absence.total_date_absences')]=$totalDateAbsences;
        $item[trans('absence.last_year_absences_date')]=displayNumberAbsenceRedundancyByYear(
            $numberAbsenceRedundancyOfYearOld,
            $numberDaysOffFromTo,
            empty(request()->get('month_absence'))?null:request()->get('month_absence')
        );

        $item[trans('absence.absented_date')]=$absenceService->getSalaryDate(
            $salaryDaysOff,
            $totalDefaultDateAbsences,
            $numberOfDaysOffBeforeJuly,
            $numberAbsenceRedundancyOfYearOld,
            empty(request()->get('month_absence'))?null:request()->get('month_absence'),
            $totalDateAbsences
        ) ;
        $item[trans('absence.non_salary_date')]= $absenceService->numberOfDaysOff(
            $listAbsence,
            empty(request()->get('year_absence'))?date('Y'):request()->get('year_absence'),
            empty(request()->get('month_absence'))?null:request()->get('month_absence'),
            getAbsenceType(config('settings.status_common.absence_type.non_salary_date'))
        );
        $item[trans('absence.insurance_date')]=$absenceService->numberOfDaysOff(
            $listAbsence,
            empty(request()->get('year_absence'))?date('Y'):request()->get('year_absence'),
            empty(request()->get('month_absence'))?null:request()->get('month_absence'),
            getAbsenceType(config('settings.status_common.absence_type.insurance_date'))
        );
        $item[trans('absence.subtract_salary_date')]=$absenceService->getSubtractSalaryDate(
            $salaryDaysOff,
            $totalDefaultDateAbsences,
            $numberOfDaysOffBeforeJuly,
            $numberAbsenceRedundancyOfYearOld,
            empty(request()->get('month_absence'))?null:request()->get('month_absence'),
            $totalDateAbsences
        );
        $item[trans('absence.remaining_date')]=getRemainingDate(
            $salaryDaysOff,
            $totalDateAbsences
        );

        $object[]=$item;
    }
    return $object;
}
function getAbsenceHrList($employees,$absenceService){
    $absence_list = []; 
    $length = 0;
    foreach($employees as $employee){
        $obj_absence = Employee::emp_absence($employee->id);
        $absence_list[$length++] = [
            "id" => $employee->id,
            "name" => $employee->name,
            "email" => $employee->email,
            "pemission_annual_leave" => $obj_absence['pemission_annual_leave'], //số ngày được phép năm nay
            "remaining_last_year" => $obj_absence['remaining_last_year'], //số ngày còn lại từ năm trước
            "remaining_this_year" => $obj_absence['remaining_this_year'], //số ngày phép năm nay còn lại
            "annual_leave" => $obj_absence['annual_leave'], //số ngày nghỉ phép năm
            "unpaid_leave" => $obj_absence['unpaid_leave'], //số ngày nghỉ không lương
            "maternity_leave" => $obj_absence['maternity_leave'], //nghỉ thai sản
            "marriage_leave" => $obj_absence['marriage_leave'], // nghỉ cưới hỏi
            "bereavement_leave" => $obj_absence['bereavement_leave'], // nghỉ tang chế
            "sick_leave" => $obj_absence['sick_leave'], //nghỉ ốm
        ];
    }
    return $absence_list;
}