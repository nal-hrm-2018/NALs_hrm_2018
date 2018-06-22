<?php
namespace App\Absence;

use App\Models\Employee;
use App\Models\Holiday;
use App\Models\Absence;
use App\Models\AbsenceStatus;
use App\Models\AbsenceType;
use DateTime;
use Carbon\Carbon;
class AbsenceService{

    //so ngay da nghi theo thang , nam
    function numberOfDaysOff($id, $year, $month, $absence_type){
        // $year = (int)$year;
        $objAS = new AbsenceService;
        if($month == 0){
            $listAbsence = Absence::select()
                ->join('absence_types', 'absences.absence_type_id', '=', 'absence_types.id')
                ->join('absence_statuses', 'absences.absence_status_id', '=', 'absence_statuses.id')
                ->where('absences.delete_flag', 0)
                ->where('absence_statuses.id', 2)
                ->where('employee_id',$id)
                ->where('absence_types.id', $absence_type)
                ->where(function ($query) use($year) {
                    $query->whereYear('absences.from_date', $year)
                        ->orWhereYear('absences.to_date', $year);
                })
                ->get();
        }else{
            $input =Carbon::create($year,$month);
            $listAbsence = Absence::select()
                ->join('absence_types', 'absences.absence_type_id', '=', 'absence_types.id')
                ->join('absence_statuses', 'absences.absence_status_id', '=', 'absence_statuses.id')
                ->where('absences.delete_flag', 0)
                ->where('absence_statuses.id', 2)
                ->where('employee_id',$id)
                ->where('absence_types.id', $absence_type)
                ->whereRaw("(date_format(absences.from_date,'%Y-%m')<=".$input.")")
                ->whereRaw("(date_format(absences.to_date,'%Y-%m')>=".$input.")")

                ->get();
        }

        $sumDate = 0;
        if($month == 0){
            foreach ($listAbsence as $objAbsence) {
                if((int)date_create($objAbsence->from_date)->format('Y') < $year && (int)date_create($objAbsence->to_date)->format('Y') > $year){
                    $startDate = Carbon::create($year,1,1);
                    $endDate = Carbon::create($year,12,31);
                }else if((int)date_create($objAbsence->from_date)->format('Y') < $year){
                    $startDate = Carbon::create($year,1,1,0);
                    $endDate = Carbon::parse($objAbsence->to_date);
                } else if((int)date_create($objAbsence->to_date)->format('Y') > $year){
                    $startDate = Carbon::parse($objAbsence->from_date);
                    $endDate = Carbon::create($year,12,31,23,59);
                } else {
                    $startDate = Carbon::parse($objAbsence->from_date);
                    $endDate = Carbon::parse($objAbsence->to_date);
                }
                $sumDate += $objAS->sumDate($startDate,$endDate);

            }
        }else{
            foreach ($listAbsence as $objAbsence) {
                if((int)date_create($objAbsence->from_date)->format('m') < $month && (int)date_create($objAbsence->to_date)->format('m') > $month){
                    $startDate = Carbon::create($year,$month,1);
                    $endDate = Carbon::create($year,$month,$startDate->daysInMonth);
                } else if((int)date_create($objAbsence->from_date)->format('m') < $month){
                    $startDate = Carbon::create($year,$month,1,0);
                    $endDate = Carbon::parse($objAbsence->to_date);
                } else if((int)date_create($objAbsence->to_date)->format('m') > $month){
                    $startDate = Carbon::parse($objAbsence->from_date);
                    $endDate = Carbon::create($year,$month,$startDate->daysInMonth,23,59);
                } else {
                    $startDate = Carbon::parse($objAbsence->from_date);
                    $endDate = Carbon::parse($objAbsence->to_date);
                }
                $sumDate += $objAS->sumDate($startDate,$endDate);               
            }

        }
        return $sumDate;
    }
    // ngay da nghi truoc thang 7
    function numberOfDaysOffBeforeJuly($id,$year,$month,$absence_type){
        if($month != 0){
            $objAS = new AbsenceService;
            $listAbsence = Absence::select()
                ->join('absence_types', 'absences.absence_type_id', '=', 'absence_types.id')
                ->join('absence_statuses', 'absences.absence_status_id', '=', 'absence_statuses.id')
                ->where('absences.delete_flag', 0)
                ->where('absence_statuses.id', 2)
                ->where('absence_types.id', $absence_type)
                ->whereMonth('absences.from_date','<', $month)
                ->whereYear('absences.from_date', $year)
                ->orWhereMonth('absences.to_date','<',$month)
                ->whereYear('absences.to_date', $year)
                ->get();
            $sumDate = 0;
            foreach ($listAbsence as $objAbsence) {
                if((int)date_create($objAbsence->from_date)->format('Y') < $year && ((int)date_create($objAbsence->to_date)->format('Y') == $year && (int)date_create($objAbsence->to_date)->format('m') >= $month || (int)date_create($objAbsence->to_date)->format('Y') > $year )){
                    $startDate = Carbon::create($year,1,1);
                    $endDate = Carbon::create($year,$month,1);
                    $endDate = $endDate->subDay();
                }else if((int)date_create($objAbsence->from_date)->format('Y') < $year){
                    $startDate = Carbon::create($year,1,1,0);
                    $endDate = Carbon::parse($objAbsence->to_date);
                } else if((int)date_create($objAbsence->to_date)->format('Y') == $year && (int)date_create($objAbsence->to_date)->format('m') >= $month){
                    $startDate = Carbon::parse($objAbsence->from_date);
                    $endDate = Carbon::create($year,$month,1,23,59);
                    $endDate = $endDate->subDay();
                } else {
                    $startDate = Carbon::parse($objAbsence->from_date);
                    $endDate = Carbon::parse($objAbsence->to_date);
                }
                $sumDate += $objAS->sumDate($startDate,$endDate);
            }
            return $sumDate;
        }else{
            return 0;
        }
    }
    //quy doi
    function countHours($startHours,$endHours){
        $count = 0;
        if($startHours < 11.5 && $endHours < 11.5){
            if($startHours >= 8){
                $count += $endHours - $startHours;
            }else{
                $count += $endHours - 8;
            }
            
        }else if($startHours < 11.5 && $endHours > 11.5){
            if($startHours >= 8){
                $count += 11.5 - $startHours;
            }else{
                $count += 11.5 - 8;
            }
            if($endHours > 13){
                if($endHours <= 17.5){
                    $count += $endHours - 13;
                }else{
                    $count += 17.5 - 13;
                }
                
            }
        }else if($startHours > 13 && $endHours > 13){
            if($endHours <= 17.5){
                $count += $endHours - $startHours;
            }else{
                $count += 17.5 - $startHours;
            }
        }
        return $count;
    }
    //quy doi
    function formatTime($date){
        $hours = $date->hour;
        $minute = $date->minute;
        if($minute <= 30){
            return ($hours + 0.5);
        }else{
            return ($hours + 1);
        }
    }
    // quy doi
    function countDay($hours){
        if($hours <= 4){
            return 0.5;
        }else{
            return 1;
        }
    }
    // dem tong so ngay trong khoang start > end ,tru gio ngoai hanh chinh, tru di ngay thu 7,8 va ngay le
    function sumDate($startDate, $endDate){
        $objAS = new AbsenceService;
        $sumDate = 0;
        $countDate = $startDate->diffInDaysFiltered(function(Carbon $date) {
                        return !($date->isWeekend());
                    }, $endDate);
        if($countDate > 0){
            if($startDate->isWeekend() && $endDate->isWeekend()){
                $sumDate += $countDate;
            }else if(!($startDate->isWeekend()) || !($endDate->isWeekend())){
                if($countDate == 1 && $startDate->day == $endDate->day){
                    if(!($objAS->checkHoliday($startDate))){
                        $countHours = $objAS->countHours($objAS->formatTime($startDate),$objAS->formatTime($endDate));
                        $sumDate += $objAS->countDay($countHours);
                    }
                    
                }
                if($countDate > 1){
                    if(!($startDate->isWeekend()) && !($objAS->checkHoliday($startDate))){
                        $countHours = $objAS->countHours($objAS->formatTime($startDate),17.5);
                        $sumDate += $objAS->countDay($countHours);
                    }
                    $countDate --;
                    if(!($endDate->isWeekend()) && !($objAS->checkHoliday($endDate))){
                        $countHours = $objAS->countHours(8,$objAS->formatTime($endDate));
                        $sumDate += $objAS->countDay($countHours);
                    }
                    $countDate --;
                    if($countDate > 0){
                        $countHoliday = $objAS->countHoliday($startDate->addDay(), $endDate->subDay());
                        $sumDate += $countDate - $countHoliday;
                    }                    
                }
            }
        }  
        return $sumDate;  
    }
    // kiem tra tu start -> end co bao nhieu ngay le~
    function countHoliday($startDate, $endDate){

        $countHoliday = $startDate->diffInDaysFiltered(function(Carbon $date) {

                        $objHoliday = Holiday::select()
                                    ->where('delete_flag', 0)
                                    ->whereDay('date', $date->day)
                                    ->whereMonth('date', $date->month)
                                    ->whereYear('date', $date->year)
                                    ->first();
                        if($objHoliday != null && !($date->isWeekend())){

                            return true;

                        }
                         else
                         {
                            return false;
                        }               
                    }, $endDate);

        return $countHoliday;
    }
    // kiem tra date co phai ngay le
    function checkHoliday($date){
        $objHoliday = Holiday::select()
                    ->where('delete_flag', 0)
                    ->whereDay('date', $date->day)
                    ->whereMonth('date', $date->month)
                    ->whereYear('date', $date->year)
                    ->first();
        if($objHoliday != null){
            return true;
        } else{
            return false;
        }               
    }
    // so ngay duoc nghi phep trong nam
	function absenceDateOnYear($id, $year){
        $sumDate = 0;
        $year = (int)$year;
        $currentDate = new DateTime;

        // ngay bat dau hop dong
        $objEmployee = Employee::find($id);
        $dateStart =  date_create($objEmployee->startwork_date);
        $startDate = (int)$dateStart->format('d');
        $startMonth = (int)$dateStart->format('m');
        $startYear = (int)$dateStart->format('Y');
        // ngay ket thuc hop dong
        $dateEnd = date_create($objEmployee->endwork_date);
        $endDate = (int)(int)$dateEnd->format('d');
        $endMonth = (int)$dateEnd->format('m');
        $endYear = (int)$dateEnd->format('Y');

        if($year == $startYear && $year == $endYear){
            // nam bat dau , ket thuc hop dong cung nam voi input nam
            if($startMonth == $endMonth){
                // ngay bat dau , ket thuc nam trong cung 1 thang
                if($endDate - $startDate > 15){
                    $sumDate ++;
                }
                // so ngay duoc nghi
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
        if($year == $startYear && $year < $endYear){
            if($startDate <= 15){
                $sumDate++;
            }
            $sumDate += 12 - ($startMonth+1)+1;
            return $sumDate;
        }
        if($year > $startYear && $year < $endYear){
            return 12;
        }
        return 12;
    }
    function absenceDateOnMonthYear($id, $year , $month){
        $sumDate = 0;
        $year = (int)$year;
        $currentDate = new DateTime;

        // ngay bat dau hop dong
        $objEmployee = Employee::find($id);
        $dateStart =  date_create($objEmployee->startwork_date);
        $startDate = (int)$dateStart->format('d');
        $startMonth = (int)$dateStart->format('m');
        $startYear = (int)$dateStart->format('Y');
        // ngay ket thuc hop dong
        $dateEnd = date_create($objEmployee->endwork_date);
        $endDate = (int)(int)$dateEnd->format('d');
        $endMonth = (int)$dateEnd->format('m');
        $endYear = (int)$dateEnd->format('Y');

        if($year == $startYear && $year == $endYear){
            // nam bat dau , ket thuc hop dong cung nam voi input nam
            if($startMonth == $endMonth){
                // ngay bat dau , ket thuc nam trong cung 1 thang
                if($endDate - $startDate > 15){
                    $sumDate ++;
                }
                // so ngay duoc nghi
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
        if($year == $startYear && $year < $endYear){
            if($startDate <= 15){
                $sumDate++;
            }
            $sumDate += 12 - ($startMonth+1)+1;
            return $sumDate;
        }
        if($year > $startYear && $year < $endYear){
            return 12;
        }
        return 12;
    }
    // nam cong them lam lau nam
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
    //so ngay nghi du nam cu
    function numberAbsenceRedundancyOfYearOld($id, $year){
        return app(\App\Service\AbsenceService::class)->getnumberAbsenceRedundancyByYear($id, $year);
    }
    // so ngay phep du bi tru
    function subRedundancy($id, $year){
        $dateNow = new DateTime;
        $objAS = new AbsenceService;
        $dateNow = Carbon::create($dateNow->format('Y'),$dateNow->format('m'),$dateNow->format('d'));

        if($dateNow->year == $year && $dateNow->month < 6){
            $num = $objAS->numberOfDaysOffBeforeJuly($id, $year, $dateNow->month, 4);
            if($objAS->numberAbsenceRedundancyOfYearOld($id, $year-1) - $num >= 0){
                return $num;
            }else{
                $objAS->numberAbsenceRedundancyOfYearOld($id, $year-1);
            }
        }else{
            return $objAS->numberAbsenceRedundancyOfYearOld($id, $year-1);
        }

    }
    //so ngay nghi  phep bi tru
    function subDateAbsences($id, $year){
        $dateNow = new DateTime;
        $objAS = new AbsenceService;
        $dateNow = Carbon::create($dateNow->format('Y'),$dateNow->format('m'),$dateNow->format('d'));
        if($dateNow->year == $year && $dateNow->month < 7){
            $num = $objAS->numberOfDaysOffBeforeJuly($id, $year, $dateNow->month, 4);
            if($objAS->numberAbsenceRedundancyOfYearOld($id, $year-1) - $num >= 0){
                return $objAS->absenceDateOnYear($id, $dateNow->year);
            }else{
                return $num - $objAS->numberAbsenceRedundancyOfYearOld($id, $year-1);
            }
        }else{
            $num = $objAS->numberOfDaysOffBeforeJuly($id, $year, 7, 4);
            $num1 = $objAS->numberOfDaysOff($id, $year, $dateNow->month, 4);
            $num2 = $objAS->numberAbsenceRedundancyOfYearOld($id, $year-1);
            if($num2 - $num >= 0){
                return $num1 - $num;
            }else{
                return $num1 - ($num - $num2);
            }
        }

    }
    // tong so ngay duoc nghi phep trong nam nay (tong so ngay co dinh + tong ngay du nam cu~ + lam lau nam)
    function totalDateAbsences($id, $year)
    {
        $dateNow = new DateTime;
        $objAS = new AbsenceService;
        $dateNow = Carbon::create($dateNow->format('Y'), $dateNow->format('m'), $dateNow->format('d'));
            if ($dateNow->year == $year && $dateNow->month < 7) {
                return $objAS->absenceDateOnYear($id, $year) + $objAS->numberAbsenceRedundancyOfYearOld($id, $year - 1) + $objAS->numberAbsenceAddPerennial($id, $year);
            } else {
                return $objAS->absenceDateOnYear($id, $year) + $objAS->numberAbsenceAddPerennial($id, $year);
            }
    }

}
