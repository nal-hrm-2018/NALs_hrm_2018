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

    function isDaysOffIsBelongMonth($objAbsence,$month){
        if(
        (strtotime($month) == strtotime(date('Y-m-01', strtotime($objAbsence->from_date))) &&
            strtotime($month) != strtotime(date('Y-m-01', strtotime($objAbsence->to_date)))
        ) ||
        ((strtotime($month) == strtotime(date('Y-m-01', strtotime($objAbsence->to_date))) &&
            strtotime($month) != strtotime(date('Y-m-01', strtotime($objAbsence->from_date))))

        )||
        ((strtotime($month) == strtotime(date('Y-m-01', strtotime($objAbsence->from_date))) &&
            strtotime($month) == strtotime(date('Y-m-01', strtotime($objAbsence->to_date))))
        ) ||
        (
        (strtotime($month) > strtotime(date('Y-m-01', strtotime($objAbsence->from_date)))
            && strtotime($month) < strtotime(date('Y-m-01', strtotime($objAbsence->to_date))))
        )
        ){
            return true;
        }
        return false;
    }

    function getNumberOfDaysOff($listAbsence,$year,$month, $absence_type){
        $objAS = new AbsenceService;
        $sumDate = 0;
        if($month == 0){
            foreach ($listAbsence as $objAbsence) {
                if($objAbsence->absence_type_id === $absence_type){
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
            }
        }else{
            foreach ($listAbsence as $objAbsence) {
                if($objAbsence->absence_type_id === $absence_type ) {
                    if ((int)date_create($objAbsence->from_date)->format('m') < $month && (int)date_create($objAbsence->to_date)->format('m') > $month) {
                        $startDate = Carbon::create($year, $month, 1);
                        $endDate = Carbon::create($year, $month, $startDate->daysInMonth);
                    } else if ((int)date_create($objAbsence->from_date)->format('m') < $month) {
                        $startDate = Carbon::create($year, $month, 1, 0);
                        $endDate = Carbon::parse($objAbsence->to_date);
                    } else if ((int)date_create($objAbsence->to_date)->format('m') > $month) {
                        $startDate = Carbon::parse($objAbsence->from_date);
                        $endDate = Carbon::create($year, $month, $startDate->daysInMonth, 23, 59);
                    } else {
                        $startDate = Carbon::parse($objAbsence->from_date);
                        $endDate = Carbon::parse($objAbsence->to_date);
                    }
                    $sumDate += $objAS->sumDate($startDate, $endDate);
                }
            }

        }
        return $sumDate;
    }
    function numberOfDaysOff($id, $year, $month, $absence_type, $absence_status){
        // $year = (int)$year;
        $objAS = new AbsenceService;
        if($month == 0){
            $listAbsence = Absence::select()
                ->join('absence_types', 'absences.absence_type_id', '=', 'absence_types.id')
                ->join('absence_statuses', 'absences.absence_status_id', '=', 'absence_statuses.id')
                ->where('absences.delete_flag', 0)
                ->where('absences.employee_id',$id)
                ->where('absences.absence_status_id', $absence_status)
                ->where('absences.absence_type_id', $absence_type)
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
        }else{
            $input =Carbon::create($year,$month)->format('Y-m');
            $listAbsence = Absence::select()
                ->join('absence_types', 'absences.absence_type_id', '=', 'absence_types.id')
                ->join('absence_statuses', 'absences.absence_status_id', '=', 'absence_statuses.id')
                ->where('absences.delete_flag', 0)
                ->where('absences.employee_id',$id)
                ->where('absence_statuses.id', $absence_status)
                ->where('absence_types.id', $absence_type)
                /*->where(function ($query) use($year,$month) {
                        $query->whereYear('absences.from_date', $year)
                            ->whereMonth('absences.from_date', $month);
                    })
                ->orWhere(function ($query) use($year,$month) {
                            $query->whereYear('absences.to_date', $year)
                                ->whereMonth('absences.to_date', $month);
                        })
                ->orWhere(function ($query) use($year,$month) {
                            $query->whereYear('absences.from_date','<=' ,$year)
                                ->whereMonth('absences.to_date', '>=',$year);
                        })  */              
                ->where(function ($query) use($input) {
                    $query->orwhere(function ($query) use($input) {
                        $query->whereRaw("(date_format(absences.from_date,'%Y-%m') = '".$input."')")
                            -> whereRaw("(date_format(absences.to_date,'%Y-%m') != '".$input."')");
                    });
                    $query->orwhere(function ($query) use($input) {
                        $query->whereRaw("(date_format(absences.from_date,'%Y-%m') != '".$input."')")
                            ->whereRaw("(date_format(absences.to_date,'%Y-%m') = '".$input."')");
                    });
                    $query->orwhere(function ($query) use($input) {
                        $query->whereRaw("(date_format(absences.from_date,'%Y-%m') = '".$input."')")
                            ->whereRaw("(date_format(absences.to_date,'%Y-%m') = '".$input."')");
                    });
                    $query->orwhere(function ($query) use($input) {
                        $query->whereRaw("(date_format(absences.from_date,'%Y-%m') < '".$input."')")
                            ->whereRaw("(date_format(absences.to_date,'%Y-%m') > '".$input."')");
                    });
                })
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
                if(
                    ((int)date_create($objAbsence->from_date)->format('m') < $month &&
                    (int)date_create($objAbsence->from_date)->format('Y') == $year && 
                    (int)date_create($objAbsence->to_date)->format('m') > $month &&  
                    (int)date_create($objAbsence->to_date)->format('Y') == $year)
                    ||
                    ((int)date_create($objAbsence->from_date)->format('Y') < $year &&
                    (int)date_create($objAbsence->to_date)->format('Y') > $year)
                ){
                    $startDate = Carbon::create($year,$month,1);
                    $endDate = Carbon::create($year,$month,$startDate->daysInMonth);
                } else if(
                        ((int)date_create($objAbsence->from_date)->format('m') < $month &&
                        (int)date_create($objAbsence->from_date)->format('Y') == $year) 
                        || 
                        ((int)date_create($objAbsence->from_date)->format('Y') < $year)
                    ){
                    $startDate = Carbon::create($year,$month,1,0);
                    $endDate = Carbon::parse($objAbsence->to_date);
                } else if(
                        ((int)date_create($objAbsence->to_date)->format('m') > $month &&
                        (int)date_create($objAbsence->to_date)->format('Y') == $year)
                        ||
                        ((int)date_create($objAbsence->to_date)->format('Y') > $year)
                    ){
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
    // ngay nghi truoc thang 7
    function numberOfDaysOffBeforeJuly($id,$year,$month,$absence_type, $absence_status){
        $objAS = new AbsenceService;
        if($month != 0){
            $sumDate = 0;
            for($i = 1; $i <= $month; $i++){
                $sumDate += $objAS->numberOfDaysOff($id,$year,$i,$absence_type, $absence_status);
            }
            return $sumDate;
        }else{
            return 0;
        }
    }

    function countHours($startHours,$endHours){
        $count = 0;
        if($startHours < 11.5 && $endHours < 11.5 && $endHours > $startHours){
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
        }else if($startHours > 13 && $endHours > 13 && $endHours > $startHours){
            if($endHours <= 17.5){
                $count += $endHours - $startHours;
            }else{
                $count += 17.5 - $startHours;
            }
        }
        return $count;
    }
    function formatTime($date){
        $hours = $date->hour;
        $minute = $date->minute;
        if($minute <= 30){
            return ($hours + 0.5);
        }else{
            return ($hours + 1);
        }
    }
    function countDay($hours){
        if($hours <= 4 && $hours > 0){
            return 0.5;
        }else if($hours <= 8 && $hours > 4){
            return 1;
        }
    }
    function countDate($startDate, $endDate){
        $objAS = new AbsenceService;
        $total = 0;

        if($startDate->year == $endDate->year && $startDate->month == $endDate->month && $startDate->day == $endDate->day){
            if(!($startDate->isWeekend()) && !($objAS->checkHoliday($startDate))){
                $total++;
            }
        }else{
            if(!($startDate->isWeekend()) && !($objAS->checkHoliday($startDate))){
                $total++;
            }
            $startDate->addDay();
            $startDate = $startDate->create($startDate->year, $startDate->month, $startDate->day, 0,0);
            

            if(!($endDate->isWeekend()) && !($objAS->checkHoliday($endDate))){
                $total++;
            }

            $endDate->subDay();
            $endDate = $endDate->create($endDate->year, $endDate->month, $endDate->day, 23,59,59);

            if(!$startDate->eq($endDate)){
                $countDate = $startDate->diffInDaysFiltered(function(Carbon $date) {
                        $objAS = new AbsenceService;
                        return !($date->isWeekend()) && !($objAS->checkHoliday($date));
                    }, $endDate);
                $total += $countDate;

            }
        }
        return $total;
    }
    function sumDate($startDate, $endDate){
        $objAS = new AbsenceService;
        $sumDate = 0;
        $countDate = $objAS->countDate(clone $startDate, clone $endDate);
        if($countDate > 0){
            if($startDate->isWeekend() && $endDate->isWeekend()){
                $sumDate += $countDate;
            }else if(!($startDate->isWeekend()) || !($endDate->isWeekend())){
                //--------
                if(!($startDate->isWeekend()) && !($endDate->isWeekend()) && $countDate == 1 ){
                    $countHours = $objAS->countHours($objAS->formatTime($startDate),$objAS->formatTime($endDate));
                    $sumDate += $objAS->countDay($countHours);
                }else if(($startDate->isWeekend())&& $countDate == 1 ){
                    $countHours = $objAS->countHours(8,$objAS->formatTime($endDate));
                    $sumDate += $objAS->countDay($countHours);
                }else if(($endDate->isWeekend())&& $countDate == 1 ){
                    $countHours = $objAS->countHours($objAS->formatTime($startDate),17,5);
                    $sumDate += $objAS->countDay($countHours);
                }
                //----------
                else if(($endDate->isWeekend()) && $countDate == 2){
                    $countHours = $objAS->countHours($objAS->formatTime($startDate),17.5);
                    $sumDate += $objAS->countDay($countHours);

                    $sumDate ++;
                }
                else if(($startDate->isWeekend()) && $countDate == 2){
                    $sumDate ++;

                    $countHours = $objAS->countHours(8,$objAS->formatTime($endDate));
                    $sumDate += $objAS->countDay($countHours);
                }

                elseif(!($startDate->isWeekend()) && !($endDate->isWeekend()) && $countDate == 2){
                    $countHours = $objAS->countHours($objAS->formatTime($startDate),17.5);
                    $sumDate += $objAS->countDay($countHours);

                    $countHours = $objAS->countHours(8,$objAS->formatTime($endDate));
                    $sumDate += $objAS->countDay($countHours);
                }
                //----------

                else if(($endDate->isWeekend())&&$countDate > 2){
                    $countHours = $objAS->countHours($objAS->formatTime($startDate),17.5);
                    $sumDate += $objAS->countDay($countHours);
                    $countDate --;

                    $sumDate += 1;
                    $countDate --;
                    if($countDate > 0){
                        $sumDate += $countDate;
                    }                    
                }
                else if(($startDate->isWeekend())&&$countDate > 2){
                    $sumDate ++;
                    $countDate --;

                    $countHours = $objAS->countHours(8,$objAS->formatTime($endDate));
                    $sumDate += $objAS->countDay($countHours);
                    $countDate --;

                    if($countDate > 0){
                        $sumDate += $countDate;
                    }
                }
                else if(!($startDate->isWeekend())&&!($endDate->isWeekend())&&$countDate > 2){
                    $countHours = $objAS->countHours($objAS->formatTime($startDate),17.5);
                    $sumDate += $objAS->countDay($countHours);
                    $countDate --;

                    $countHours = $objAS->countHours(8,$objAS->formatTime($endDate));
                    $sumDate += $objAS->countDay($countHours);
                    $countDate --;
                    if($countDate > 0){
                        $sumDate += $countDate;
                    }
                }
            }
        }

        
        return $sumDate;  
    }

    /*function countHoliday($startDate, $endDate){

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
    }*/

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

    function absenceDateOnYear($id, $year){
        $sumDate = 0;
        $year = (int)$year;
        $currentDate = new DateTime;
//        echo $year; die();
        $year=2018;
        $objEmployee = Employee::find(1);
        $dateStart =  date_create($objEmployee->startwork_date);
        $startDate = (int)$dateStart->format('d');
        $startMonth = (int)$dateStart->format('m');
        $startYear = (int)$dateStart->format('Y');

        $dateEnd = date_create($objEmployee->endwork_date);
        $endDate = (int)(int)$dateEnd->format('d');
        $endMonth = (int)$dateEnd->format('m');
        $endYear = (int)$dateEnd->format('Y');

        if($year == $startYear && $year == $endYear){
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
        if($year == $startYear && $year < $endYear){
            if($startDate <= 15){
                $sumDate++;
            }
            $x = 12 - ($startMonth+1)+1;
            $sumDate += 12 - ($startMonth+1)+1;
            return $sumDate;
        }
        if($year > $startYear && $year < $endYear){
            return 12;
        }
        return 12;
    }

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
    function numberAbsenceRedundancyOfYearOld($id, $year){
        $employee = Employee::find($id);
        $days=$employee->extraAbsenceDates()->where('year', '=', (int)$year)->first();
        if(empty($days)){
            return 0;
        }else{
            if($days->date <0){
                return 0;
            }else if($days->date > 5){
                return 5;
            }else{
                return $days->date;
            }    
        }
    }
    // tru ngay nghi cu
    function subRedundancy($id, $year){
        $dateNow = new DateTime;
        $objAS = new AbsenceService;
        $dateNow = Carbon::create($dateNow->format('Y'),$dateNow->format('m'),$dateNow->format('d'));

        $status = AbsenceStatus::select()->where('name','accepted')->first();
        $type = AbsenceType::select()->where('name','salary_date')->first();
        if($dateNow->year == $year && $dateNow->month < 7){
            $num = $objAS->numberOfDaysOffBeforeJuly($id, $year, $dateNow->month, $type->id,$status->id);
            if($objAS->numberAbsenceRedundancyOfYearOld($id, $year-1) - $num >= 0){
                return $num;
            }else{
                return $objAS->numberAbsenceRedundancyOfYearOld($id, $year-1);
            }
        }else{

            $num = $objAS->numberOfDaysOffBeforeJuly($id, $year, 6, $type->id,$status->id);
            if($objAS->numberAbsenceRedundancyOfYearOld($id, $year-1) - $num >= 0){
                return $num;
            }else{
                return $objAS->numberAbsenceRedundancyOfYearOld($id, $year-1);
            }
        }
        
    }
    // tru ngay nghi phep
    function subDateAbsences($id, $year){
        $dateNow = new DateTime;
        $objAS = new AbsenceService;
        $dateNow = Carbon::create($dateNow->format('Y'),$dateNow->format('m'),$dateNow->format('d'));

        $status = AbsenceStatus::select()->where('name','accepted')->first();
        $type = AbsenceType::select()->where('name','salary_date')->first();

        if($dateNow->year == $year && $dateNow->month < 7){
            $num = $objAS->numberOfDaysOffBeforeJuly($id, $year, $dateNow->month, $type->id,$status->id);
            if($objAS->numberAbsenceRedundancyOfYearOld($id, $year-1) >= $num){
                if($objAS->totalDateAbsences($id,$year) > $num){
                    if($objAS->numberOfDaysOff($id, $year, 0, $type->id,$status->id) > $objAS->totalDateAbsences($id,$year)){
                        
                        return $objAS->absenceDateOnYear($id,$year) + $objAS->numberAbsenceAddPerennial($id, $year);

                    }else{
                        
                        return $objAS->numberOfDaysOff($id,$year,0, $type->id,$status->id) - $objAS->numberOfDaysOffBeforeJuly($id, $year, $dateNow->month, $type->id,$status->id);
                    }
                }else{
                    return 0;
                }
            }else{
                if($objAS->numberOfDaysOff($id, $year, 0, $type->id,$status->id) > $objAS->totalDateAbsences($id,$year)){
                    return $objAS->absenceDateOnYear($id,$year) + $objAS->numberAbsenceAddPerennial($id, $year);
                }else{
                    return $objAS->numberOfDaysOff($id, $year, 0, $type->id,$status->id) - $objAS->numberAbsenceRedundancyOfYearOld($id, $year-1);
                }
            }
        }else{
            $num = $objAS->numberOfDaysOffBeforeJuly($id, $year, 6, $type->id,$status->id);
            $num1 = $objAS->numberOfDaysOff($id, $year, 0, $type->id,$status->id);

            $num2 = $objAS->numberAbsenceRedundancyOfYearOld($id, $year-1);
            if($num2 - $num >= 0 && $year == $dateNow->year){
                return $num1 - $num;
            }else{
                if($num1 - $num2 > $objAS->numberAbsenceAddPerennial($id, $year)+$objAS->absenceDateOnYear($id,$year)){
                    return $objAS->numberAbsenceAddPerennial($id, $year) + $objAS->absenceDateOnYear($id,$year);
                }else{
                    if($num1 >= $num2){
                        return $num1 - $num2;
                    }else{
                        return $num1;
                    }
                }
            }
        }

    }
    function subtractSalaryDate($id, $year){
        $objAS = new AbsenceService;
        $status = AbsenceStatus::select()->where('name','accepted')->first();
        $type = AbsenceType::select()->where('name','salary_date')->first();

        $num1 = $objAS->totalDateAbsences($id, $year);
        $num2 = $objAS->numberOfDaysOff($id, $year, 0, $type->id, $status->id);
        $num3 = $objAS->numberOfDaysOffBeforeJuly($id,$year,6,$type->id, $status->id);
        $num4 = $objAS->numberAbsenceRedundancyOfYearOld($id, $year-1);
        if($num3 >= $num4 && $num2 >= $num1){
            if($num2 >= $num1){
                return $num2 - $num1;
            }else{
                return 0;
            }
        }else{
            if($num2 > $num1-$num4+$num3){
                return $num2 - ($num1-$num4+$num3);
            }else{
                return 0;
            }
        }
    }
    //ngay phep con lai
    function sumDateExistence($id, $year){
        $objAS = new AbsenceService;
        return $objAS->absenceDateOnYear($id, $year) + $objAS->numberAbsenceAddPerennial($id,$year) - $objAS->subDateAbsences($id, $year);
    }
    function sumDateRedundancyExistence($id, $year){
        $dateNow = new DateTime;
        $objAS = new AbsenceService;
        $dateNow = Carbon::create($dateNow->format('Y'),$dateNow->format('m'),$dateNow->format('d'));
        return $objAS->numberAbsenceRedundancyOfYearOld($id, $year-1) - $objAS->subRedundancy($id, $year);
    }
    function totalDateAbsences($id, $year){
        $dateNow = new DateTime;
        $objAS = new AbsenceService;
        $dateNow = Carbon::create($dateNow->format('Y'),$dateNow->format('m'),$dateNow->format('d'));
        return $objAS->absenceDateOnYear($id, $year) + $objAS->numberAbsenceRedundancyOfYearOld($id, $year-1) + $objAS->numberAbsenceAddPerennial($id,$year);
    }
}
