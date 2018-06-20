<?php
namespace App\Absence;

use App\Models\Employee;
use App\Models\Absence;
use App\Models\AbsenceStatus;
use App\Models\AbsenceType;
use DateTime;
use Carbon\Carbon;
class AbsenceService{


    function soNgayNghiPhep($id, $year, $month, $absence_type){
        // $year = (int)$year;
        $objAS = new AbsenceService;
        if($month == 0){
            $listAbsence = Absence::select()
                ->join('absence_types', 'absences.absence_types_id', '=', 'absence_types.id')
                ->join('absence_status', 'absences.absence_status_id', '=', 'absence_status.id')
                ->where('absences.delete_flag', 0)
                ->where('absence_status.id', 5)
                ->where('absence_types.id', $absence_type)
                ->whereYear('absences.from_date', $year)
                ->orWhereYear('absences.to_date', $year)
                ->get();
        }else{
            $listAbsence = Absence::select()
                ->join('absence_types', 'absences.absence_types_id', '=', 'absence_types.id')
                ->join('absence_status', 'absences.absence_status_id', '=', 'absence_status.id')
                ->where('absences.delete_flag', 0)
                ->where('absence_status.id', 5)
                ->where('absence_types.id', $absence_type)
                ->whereMonth('absences.from_date', $month)
                ->orWhereMonth('absences.to_date', $month)
                ->where(function ($query) use($year) {
                    $query->whereYear('absences.from_date', $year)
                          ->orWhereYear('absences.to_date', $year);
                })
                ->where(function ($query) use($year) {
                    $query->whereYear('absences.to_date', $year)
                          ->orWhereYear('absences.from_date', $year);
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
                    $startDate = Carbon::create($year,1,1);
                    $endDate = Carbon::parse($objAbsence->to_date);
                } else if((int)date_create($objAbsence->to_date)->format('Y') > $year){
                    $startDate = Carbon::parse($objAbsence->from_date);
                    $endDate = Carbon::create($year,12,31);
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
                    $startDate = Carbon::create($year,$month,1);
                    $endDate = Carbon::parse($objAbsence->to_date);
                } else if((int)date_create($objAbsence->to_date)->format('m') > $month){
                    $startDate = Carbon::parse($objAbsence->from_date);
                    $endDate = Carbon::create($year,$month,$startDate->daysInMonth);
                } else {
                    $startDate = Carbon::parse($objAbsence->from_date);
                    $endDate = Carbon::parse($objAbsence->to_date);
                }
                $sumDate += $objAS->sumDate($startDate,$endDate);               
            }

        }
        return $sumDate;
    }

    /*function countDate($startDate, $endDate){
        $objAS = new AbsenceService;
        $start = $objAS->formatDate(date_create($startDate));
        $end = $objAS->formatDate(date_create($endDate));

    }*/
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
    function doiGio($date){
        $hours = $date->hour;
        $minute = $date->minute;
        if($minute <= 30){
            return ($hours + 0.5);
        }else{
            return ($hours + 1);
        }
    }
    function countDay($hours){
        if($hours <= 4){
            return 0.5;
        }else{
            return 1;
        }
    }
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
                    $countHours = $objAS->countHours($objAS->doiGio($startDate),$objAS->doiGio($endDate));
                    $sumDate += $objAS->countDay($countHours);
                }
                if($countDate == 2 && $startDate->day == ($endDate->day-1)){
                    $countHours = $objAS->countHours($objAS->doiGio($startDate),17.5);
                    $sumDate += $objAS->countDay($countHours);
                    $countHours = $objAS->countHours(8,$objAS->doiGio($endDate));
                    $sumDate += $objAS->countDay($countHours);
                }
                if($countDate > 2){
                    if(!($startDate->isWeekend())){
                        $countHours = $objAS->countHours($objAS->doiGio($startDate),17.5);
                        $sumDate += $objAS->countDay($countHours);
                        $countDate --;
                    }
                    if(!($endDate->isWeekend())){
                        $countHours = $objAS->countHours(8,$objAS->doiGio($endDate));
                        $sumDate += $objAS->countDay($countHours);
                        $countDate --;
                    }
                    $sumDate += $countDate;
                }
                
            }
        }  
        return $sumDate;  
    }
	function soNgayDuocNghiPhep($id, $year){
        $sumDate = 0;
        $year = (int)$year;
        $currentDate = new DateTime;

        $objEmployee = Employee::find($id);
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
            $sumDate += 12 - ($startMonth+1)+1;
            return $sumDate;
        }
        if($year > $startYear && $year < $endYear){
            return 12;
        }

    }
    function soNgayDuocNghiPhepHienTai($id, $year){

    }
}
