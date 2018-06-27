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
    protected $absenceService;
    public function __construct()
    {
        $this->absenceService = app(AbsenceService::class);
    }

    public function add($year,$employee_id){
            $employee = Employee::find($employee_id);
            if (!empty($employee) && !$this->isDuplicateExtraAbsenceDate($year,$employee_id)) {
                $absence = new \App\Absence\AbsenceService();
                //tim so ngay nghi du nam cu
                $numberAbsenceRedundancyOfYearOld = ExtraAbsenceDate::where('employee_id',$employee_id)
                                                                ->where('year',$year-1)->where('delete_flag',0)->first();
                if(empty($numberAbsenceRedundancyOfYearOld)){
                    $numberAbsenceRedundancyOfYearOld=0;
                }else{
                    $numberAbsenceRedundancyOfYearOld=$numberAbsenceRedundancyOfYearOld->date;
                }
                // tong ngay nghi trong nam nay
                $numberOfDaysOff = $absence->numberOfDaysOff(
                    $employee_id, $year, 0,
                    getAbsenceType(config('settings.status_common.absence_type.salary_date')),
                    getAbsenceStatuses(config('settings.status_common.absence.accepted')));

                //tong ngay nghi truoc thang 7
                $numberOfDaysOffBeforeJuly = $this->absenceService->getNumberDaysOffFromTo(
                    $employee,
                    7,
                    $year,
                    getAbsenceType(config('settings.status_common.absence_type.salary_date')),
                    getAbsenceStatuses(config('settings.status_common.absence.accepted'))
                );
                // tong ngay con lai cua nam nay
                $totalDateAbsences = $this->absenceService->totalDateAbsences(
                    $employee,
                    $year,
                    7,
                    $numberAbsenceRedundancyOfYearOld,
                    $numberOfDaysOff,
                    $numberOfDaysOffBeforeJuly
                );

                $days = max(0,$totalDateAbsences);
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
        $employee = Employee::find($employee_id);
        $extraAbsenceDate = ExtraAbsenceDate::where('employee_id',$employee_id)
            ->where('year',$year)->where('delete_flag',0)->first();
        if (!empty($employee)&&!empty($extraAbsenceDate)) {
            $absence = new \App\Absence\AbsenceService();

            //tim so ngay nghi du nam cu
            $numberAbsenceRedundancyOfYearOld = ExtraAbsenceDate::where('employee_id',$employee_id)
                ->where('year',$year-1)->where('delete_flag',0)->first();
            if(empty($numberAbsenceRedundancyOfYearOld)){
                $numberAbsenceRedundancyOfYearOld=0;
            }else{
                $numberAbsenceRedundancyOfYearOld=$numberAbsenceRedundancyOfYearOld->date;
            }
            // tong ngay nghi trong nam nay
            $numberOfDaysOff = $absence->numberOfDaysOff(
                $employee_id, $year, 0,
                getAbsenceType(config('settings.status_common.absence_type.salary_date')),
                getAbsenceStatuses(config('settings.status_common.absence.accepted')));

            //tong ngay nghi truoc thang 7
            $numberOfDaysOffBeforeJuly = $this->absenceService->getNumberDaysOffFromTo(
                $employee,
                7,
                $year,
                getAbsenceType(config('settings.status_common.absence_type.salary_date')),
                getAbsenceStatuses(config('settings.status_common.absence.accepted'))
            );
            // tong ngay con lai cua nam nay
            $totalDateAbsences = $this->absenceService->totalDateAbsences(
                $employee,
                $year,
                7,
                $numberAbsenceRedundancyOfYearOld,
                $numberOfDaysOff,
                $numberOfDaysOffBeforeJuly
            );

            $days = max(0,$totalDateAbsences);
            $extraAbsenceDate->date=$days;
            return $extraAbsenceDate->save();
        }
        return false;
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