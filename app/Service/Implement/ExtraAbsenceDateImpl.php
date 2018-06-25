<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 4/18/2018
 * Time: 10:07 PM
 */

namespace App\Service\Implement;



use App\Service\AbsenceService;
use App\Models\Absence;
use App\Service\CommonService;
use Illuminate\Foundation\Console\EventMakeCommand;
use Illuminate\Support\Facades\DB;
use App\Models\Employee;
use Carbon\Carbon;
use App\Models\ExtraAbsenceDate;
use DateTime;
use App\Service\ExtraAbsenceDateService;
class ExtraAbsenceDateImpl extends CommonService implements ExtraAbsenceDateService
{

    public function __construct()
    {
    }

    public function add($year,$employee_id){
            $employee = Employee::find($employee_id);
            if (!empty($employee) && !$this->isDuplicateExtraAbsenceDate($year,$employee_id)) {
                $absence = new \App\Absence\AbsenceService();
                $numberAbsenceRedundancyOfYearOld = ExtraAbsenceDate::where('employee_id',$employee_id)
                                                                ->where('year',$year)->where('delete_flag',0)->first();
                if(empty($numberAbsenceRedundancyOfYearOld)){
                    $numberAbsenceRedundancyOfYearOld=0;
                }else{
                    $numberAbsenceRedundancyOfYearOld=$numberAbsenceRedundancyOfYearOld->date;
                }
                $numberOfDaysOff = $absence->numberOfDaysOff(
                    $employee_id, $year, 0,
                    getAbsenceType(config('settings.status_common.absence_type.salary_date')),
                    getAbsenceStatuses(config('settings.status_common.absence.accepted')));

                if($numberOfDaysOff<=$numberAbsenceRedundancyOfYearOld){
                    return $this->absenceDateOnYear($employee->id, $year)
                        + $absence->numberAbsenceAddPerennial($employee->id, $year);
                }else{
                    $total_date = $this->absenceDateOnYear($employee->id, $year) + $absence->numberAbsenceRedundancyOfYearOld($employee->id, $year - 1)
                        + $absence->numberAbsenceAddPerennial($employee->id, $year) - $dayoff;
                    if($total_date<=0){
                        return 0;
                    }
                    return $total_date;
                }

                $totalDateAbsences = $absence->absenceDateOnYear($employee_id, $year)
                    + $absence->numberAbsenceAddPerennial($employee_id, $year);

                $days = max(0,($totalDateAbsences - $numberOfDaysOff));
                $extraAbsenceDate_data = [
                    'year' => $year,
                    'date' => $days,
                    'employee_id' => $employee_id,
                    'delete_flag' => 0
                ];
                $extraAbsenceDates = new ExtraAbsenceDate($extraAbsenceDate_data);
                return $extraAbsenceDates->save();
            }
            return false;
    }
    public function update($employee_id,$year){


    }

    function isDuplicateExtraAbsenceDate($year,$employee_id){
        $employee = Employee::find($employee_id);
        $year_extraabsence= $employee->extraAbsenceDates()->where('year',$year)->first();
        if(!empty($year_extraabsence))
            return true;
        return false;
    }

    // them moi cac record vao table ExtraAbsenceDate dua theo hop dong employee
    public function addRemainingDateOfYearByEmployeePolicy($employee_id)
    {
        $employee = Employee::find($employee_id);
        if (!empty($employee)) {
            $start_work = Carbon::parse($employee->startwork_date);
            $end_work=Carbon::parse($employee->endwork_date);
            for($i=$start_work->year;$i<=($end_work->year);$i++){
                $rs = $this->add($i,$employee_id);
                if(!$rs){
                    return false;
                }
            }
            return true;
        }
        return false;
    }
}