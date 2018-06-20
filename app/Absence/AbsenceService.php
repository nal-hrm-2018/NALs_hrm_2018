<?php
namespace App\Absence;

use App\Models\Employee;
use App\Models\Absence;
use App\Models\AbsenceStatus;
use App\Models\AbsenceType;
use DateTime;
use Carbon\Carbon;
class AbsenceService{


    function soNgayNghiPhep($id, $year, $month){
        // $year = (int)$year;
        $objAS = new AbsenceService;
        if($month == 0){
            $listAbsence = Absence::select()
                ->join('absence_types', 'absences.absence_types_id', '=', 'absence_types.id')
                ->join('absence_status', 'absences.absence_status_id', '=', 'absence_status.id')
                ->where('absences.delete_flag', 0)
                ->where('absence_status.name', 'Chấp nhận')
                ->where('absence_types.name', 'Nghỉ có lương')
                ->whereYear('absences.from_date', $year)
                ->orWhereYear('absences.to_date', $year)
                ->get();
        }else{
            $listAbsence = Absence::select()
                ->join('absence_types', 'absences.absence_types_id', '=', 'absence_types.id')
                ->join('absence_status', 'absences.absence_status_id', '=', 'absence_status.id')
                ->where('absences.delete_flag', 0)
                ->where('absence_status.name', 'Chấp nhận')
                ->where('absence_types.name', 'Nghỉ có lương')
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
        foreach ($listAbsence as $objAbsence) {
            if((int)date_create($objAbsence->from_date)->format('Y') < $year){
                $startDate = Carbon::create($year,1,1);
                $endDate = Carbon::parse($objAbsence->to_date);
            } else if((int)date_create($objAbsence->to_date)->format('Y') > $year){
                $startDate = Carbon::parse($objAbsence->from_date);
                $endDate = Carbon::create($year,12,31);
            } else {
                $startDate = Carbon::parse($objAbsence->from_date);
                $endDate = Carbon::parse($objAbsence->to_date);
            }
            $sumDate -= $startDate->diffInDaysFiltered(function(Carbon $date) {
                            return !($date->isWeekend());
                        }, $endDate);
            
            
        }
    }

    function countDate($startDate, $endDate){
        $objAS = new AbsenceService;
        $start = $objAS->formatDate(date_create($startDate));
        $end = $objAS->formatDate(date_create($endDate));

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
