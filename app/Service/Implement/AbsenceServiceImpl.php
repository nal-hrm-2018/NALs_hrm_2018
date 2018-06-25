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

class AbsenceServiceImpl extends CommonService implements AbsenceService
{
    protected $totalDefaultDateAbsences;
    protected $totalDaysOff;
    protected $numberOfDaysOffBeforeJuly;
    protected $numberAbsenceRedundancyOfYearOld;
    protected $numberDaysOffFromMonthStartToMonthEnd;
    protected $totalDateAbsences;

    public function __construct()
    {
    }
    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }
    public function __set($property, $value)
    {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
    }

    public function getArrayYearAbsence()
    {
        $min_year = Employee::selectRaw('min(year(startwork_date))')->first()['min(year(startwork_date))'];
//        $max_year = Absence::selectRaw('max(year(to_date))')->first()['max(year(to_date))'];
        if (empty($min_year)) {
            $array_year = [
                date('Y') => date('Y')
            ];
        } else {
            $array_year = [
                (string)$min_year => (string)$min_year
            ];
            for ($i = 1; $i <= ((int)date('Y') - $min_year); $i++) {
                $array_year[(string)($min_year + $i)] = (string)($min_year + $i);
            }
        }
        return $array_year;
    }

    // tong ngay nghi nam ngoai
    public function getnumberAbsenceRedundancyByYear($employee_id, $year)
    {
        $employee = Employee::find($employee_id);
        $days = $employee->extraAbsenceDates()->where('year', '=', (int)$year)->first();
        if (empty($days)) {
            return 0;
        } else {
            if($days->date > 5){
                return 5;
            }else{
                return $days->date;
            }
        }

    }

    // so ngay co dinh duoc nghi theo nam ( chua cong nam cu , lau nam)
    function absenceDateOnYear($id, $year)
    {
        $sumDate = 0;
        $year = (int)$year;
        $input = Carbon::create($year);
        $objEmployee = Employee::find($id);
        if (!empty($objEmployee)) {
            $start_date_policy = date_create($objEmployee->startwork_date);
            $startDate = (int)$start_date_policy->format('d');
            $startMonth = (int)$start_date_policy->format('m');
            $startYear = (int)$start_date_policy->format('Y');

            $end_date_policy = date_create($objEmployee->endwork_date);
            $endDate = (int)(int)$end_date_policy->format('d');
            $endMonth = (int)$end_date_policy->format('m');
            $endYear = (int)$end_date_policy->format('Y');

            if ($startYear != $year && $endYear <= $year) {

//                    $sumDate++;
//                    if ($endDate >= 15) {
//                        $sumDate++;
//                    }
//                    $sumDate += ($endMonth - 1) - ($input->startOfYear()->month + 1) + 1;
//                    return $sumDate;
                return 12;
            } elseif ($startYear == $year && $endYear <= $year) {

                    if ($startDate <= 15) {
                        $sumDate++;
                    }
                    if ($endDate >= 15) {
                        $sumDate++;
                    }
                    $sumDate += ($endMonth - 1) - ($startMonth + 1) + 1;
                    return $sumDate;
            } elseif ($startYear == $year && $endYear > $year) {
                if ($startDate <= 15) {
                    $sumDate++;
                }
                $sumDate += 12 - ($startMonth + 1) + 1;
                return $sumDate;
            }elseif($year == $startYear && $year == $endYear){
                if($startMonth == $endMonth){
                    if($endDate - $startDate > 15){
                        $sumDate ++;
                    }
                    return $sumDate;
                }else{
                    if($startDate <= 15){
                        $sumDate++;
                    }
                    if($endDate >= 15){
                        $sumDate++;
                    }
                    $sumDate += ($endMonth - 1) - ($startMonth+1)+1;
                    return $sumDate;
                }
            }
            else {
                return 12;
            }
        }
        return -1;
    }

    //tong ngay duoc nghi theo nam , thang
    function totalDateAbsences($employee, $year, $month,$numberAbsenceRedundancyOfYearOld,$dayoff)
    {
        if (!empty($month)) {
            if ((int)$month < 7) {
                //tong ngay duoc phep nghi truoc thang 7
                $total_date = $this->absenceDateOnYear($employee->id, $year) + $this->getnumberAbsenceRedundancyByYear($employee->id, $year - 1)
                    + $this->numberAbsenceAddPerennial($employee->id, $year) - $dayoff;
                if($total_date<=0){
                    return 0;
                }
                return $total_date;
            } else {
                //tong ngay duoc phep nghi sau thang 7
                if($dayoff<=$numberAbsenceRedundancyOfYearOld){
                    return $this->absenceDateOnYear($employee->id, $year)
                        + $this->numberAbsenceAddPerennial($employee->id, $year);
                }else{
                    $total_date = $this->absenceDateOnYear($employee->id, $year) + $this->getnumberAbsenceRedundancyByYear($employee->id, $year - 1)
                        + $this->numberAbsenceAddPerennial($employee->id, $year) - $dayoff;
                    if($total_date<=0){
                        return 0;
                    }
                    return $total_date;
                }
            }
        } else {
            return $this->absenceDateOnYear($employee->id, $year) + $numberAbsenceRedundancyOfYearOld
                + $this->numberAbsenceAddPerennial($employee->id, $year);
        }
    }

    // so ngay da nghi theo nam , thang
    function numberOfDaysOff($listAbsence, $year, $month, $absence_type)
    {
        $AbService = new \App\Absence\AbsenceService();
        return $AbService->getNumberOfDaysOff($listAbsence, $year, $month, $absence_type);
    }

    // so ngay da nghi tu` thang , den thang
    function getNumberDaysOffFromTo($employee, $to_month, $year, $absence_type, $absence_status)
    {
        if(!empty($to_month)){
            $start_work_date = Carbon::parse($employee->startwork_date);
            if ((int)$start_work_date->year < $year) {
                $start_work_date = 1;
            }else{
                $start_work_date=$start_work_date->month;
            }
            $sumDate = 0;
            $AbService = new \App\Absence\AbsenceService();
            for ($i = $start_work_date; $i < $to_month; $i++) {
                $sumDate += $AbService->numberOfDaysOff($employee->id, $year, $i, $absence_type, $absence_status);
            }
            return $sumDate;
        }else{
            return null;
        }


    }

    function getListNumberOfDaysOff($id, $year, $month, $absence_status)
    {
        if ($month == 0) {
            $listAbsence = Absence::select()
                ->join('absence_types', 'absences.absence_type_id', '=', 'absence_types.id')
                ->join('absence_statuses', 'absences.absence_status_id', '=', 'absence_statuses.id')
                ->where('absences.delete_flag', 0)
                ->where('absences.employee_id', $id)
                ->where('absences.absence_status_id', $absence_status)
                ->where(function ($query) use ($year) {
                    $query->orwhere(function ($query) use ($year) {
                        $query->whereYear('absences.from_date', $year)
                            ->orWhereYear('absences.to_date', $year);
                    });
                    $query->orwhere(function ($query) use ($year) {
                        $query->whereYear('absences.from_date', '<', $year)
                            ->WhereYear('absences.to_date', '>', $year);
                    });
                })
                ->get();
        } else {
            $input = Carbon::create($year, $month)->format('Y-m');
            $listAbsence = Absence::select()
                ->join('absence_types', 'absences.absence_type_id', '=', 'absence_types.id')
                ->join('absence_statuses', 'absences.absence_status_id', '=', 'absence_statuses.id')
                ->where('absences.delete_flag', 0)
                ->where('absences.employee_id', $id)
                ->where('absence_statuses.id', $absence_status)
                ->where(function ($query) use ($input) {
                    $query->orwhere(function ($query) use ($input) {
                        $query->whereRaw("(date_format(absences.from_date,'%Y-%m') = '" . $input . "')")
                            ->whereRaw("(date_format(absences.to_date,'%Y-%m') != '" . $input . "')");
                    });
                    $query->orwhere(function ($query) use ($input) {
                        $query->whereRaw("(date_format(absences.from_date,'%Y-%m') != '" . $input . "')")
                            ->whereRaw("(date_format(absences.to_date,'%Y-%m') = '" . $input . "')");
                    });
                    $query->orwhere(function ($query) use ($input) {
                        $query->whereRaw("(date_format(absences.from_date,'%Y-%m') = '" . $input . "')")
                            ->whereRaw("(date_format(absences.to_date,'%Y-%m') = '" . $input . "')");
                    });
                    $query->orwhere(function ($query) use ($input) {
                        $query->whereRaw("(date_format(absences.from_date,'%Y-%m') < '" . $input . "')")
                            ->whereRaw("(date_format(absences.to_date,'%Y-%m') > '" . $input . "')");
                    });
                })
                ->get();
        }

        return $listAbsence;
    }

    // tinh so ngay nghi tru luong
    function getSubtractSalaryDate(
        $totalDaysOff ,
        $totalDefaultDateAbsences ,
        $numberOfDaysOffBeforeJuly,
        $numberAbsenceRedundancyOfYearOld,
        $month,
        $totalDateAbsences
    ){
        if (!empty($month)) {
            if(($totalDateAbsences-$totalDaysOff)<0){
                return $totalDaysOff-$totalDateAbsences;
            }else{
                return 0;
            }
        }else{
            $subRedundancy=$this->getSubRedundancy($numberAbsenceRedundancyOfYearOld,$numberOfDaysOffBeforeJuly);
            if ($subRedundancy > 5) {
                $subRedundancy = 5;
            }
            if($totalDaysOff-$subRedundancy > $totalDefaultDateAbsences ){
                return $totalDaysOff-$subRedundancy-$totalDefaultDateAbsences;
            }else{
                return 0;
            }
        }
    }

    // tinh so ngay nghi co luong
    function getSalaryDate($totalDaysOff ,
                           $totalDefaultDateAbsences ,
                           $numberOfDaysOffBeforeJuly,
                           $numberAbsenceRedundancyOfYearOld,
                           $month,
                           $totalDateAbsences){
        if (!empty($month)) {
            if (($totalDateAbsences - $totalDaysOff) < 0) {
                return $totalDateAbsences;
            } else {
                return $totalDaysOff;
            }
        } else {
            $subRedundancy = $this->getSubRedundancy($numberAbsenceRedundancyOfYearOld, $numberOfDaysOffBeforeJuly);
            if ($subRedundancy > 5) {
                $subRedundancy = 5;
            }

            if ($totalDaysOff - $subRedundancy > $totalDateAbsences) {
                return $totalDefaultDateAbsences + $subRedundancy;
            } else {
                return $totalDaysOff;
            }
        }

    }

    // tru vao phep du nam ngoai
    function getSubRedundancy($numberAbsenceRedundancyOfYearOld,$numberOfDaysOffBeforeJuly){
        if($numberAbsenceRedundancyOfYearOld>$numberOfDaysOffBeforeJuly){
            return $numberOfDaysOffBeforeJuly;
        }else{
            return $numberAbsenceRedundancyOfYearOld;
        }
    }

    //so ngay nghi duoc cong them vi lam viec lau nam
    function numberAbsenceAddPerennial($id,$year){
        $objEmployee = Employee::find($id);
        $dateNow = new DateTime;

        $startDate = date_create($objEmployee->startwork_date);
        $startDate = Carbon::create($startDate->format('Y'),$startDate->format('m'),$startDate->format('d'));

        if($year == (int) $dateNow->format('Y')){
            $endDate = Carbon::create($year,$dateNow->format('m'),$dateNow->format('d'));
        }else{
            $endDate = Carbon::create($year,12,31);
        }

        $num = $startDate->diffInYears($endDate);
        if($num >= 3 && $num<=7){
            return 5-(7-$num);
        }else if($num > 7){
            return 5;
        }else{
            return 0;
        }
    }
}