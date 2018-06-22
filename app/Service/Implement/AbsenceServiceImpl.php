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
class AbsenceServiceImpl extends CommonService implements AbsenceService
{
    public function getArrayYearAbsence()
    {
        $min_year = Absence::selectRaw('min(year(from_date))')->first()['min(year(from_date))'];
//        $max_year = Absence::selectRaw('max(year(to_date))')->first()['max(year(to_date))'];
        if(empty($min_year)){
            $array_year=[
                date('Y')=>date('Y')
            ];
        }else{
            $array_year = [
                (string)$min_year=>(string)$min_year
            ];
            for($i=1;$i<=((int)date('Y')-$min_year);$i++){
                $array_year[(string)($min_year+$i)] = (string)($min_year+$i);
            }
        }
        return $array_year;
    }
    // them 1 record vao table ExtraAbsenceDate
    public function addRemainingDateOfYear($year,$employee_id){
            $employee = Employee::find($employee_id);
            if (!empty($employee)) {
                $absence = new \App\Absence\AbsenceService();
                $totalDateAbsences = $absence->absenceDateOnYear($employee_id, $year)
                    + $absence->numberAbsenceAddPerennial($employee_id, $year);
                $numberOfDaysOff = $absence->numberOfDaysOff($employee_id, $year, 0, 4);
                $days = $totalDateAbsences - $numberOfDaysOff;
                $extraAbsenceDate_data = [
                    'year' => $year,
                    'date' => $days,
                    'employee_id' => $employee_id,
                    'delete_flag' => 0
                ];
                $extraAbsenceDates = new ExtraAbsenceDate($extraAbsenceDate_data);
                $extraAbsenceDates->save();
                return true;
            }
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
                $rs = $this->addRemainingDateOfYear($i,$employee_id);
                if(!$rs){
                    return false;
                }
            }
            return true;
        }
        return false;
    }

    public function getnumberAbsenceRedundancyByYear($employee_id,$year){
        $employee = Employee::find($employee_id);
        $days=$employee->extraAbsenceDates()->where('year', '=', (int)$year)->first();
        if(empty($days)){
            return 0;
        }else{
            return $days->date;
        }

    }

}