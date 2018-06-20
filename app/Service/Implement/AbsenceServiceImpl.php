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
use Illuminate\Support\Facades\DB;
use App\Models\Employee;
use Carbon\Carbon;
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

    public function updateRemainingDateOfYear($year,$employee_id){
        if(date('Y')!==(string)$year){
            $employee = Employee::find($employee_id);
            if(!empty($employee)){
                $startwork_date = Carbon::parse($employee->startwork_date);
                $endwork_date= Carbon::parse($employee->endwork_date);

                if($endwork_date->year>= $year){
                    if($startwork_date->year == $year && $endwork_date->year != $year){

                    }elseif($startwork_date->year!=$year && $endwork_date->year == $year){

                    }elseif($startwork_date->year == $year && $endwork_date->year == $year){

                    }elseif($startwork_date->year<$year && $endwork_date->year>$year){

                    }
                }
            }

        }
    }

}