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

class AbsenceServiceImpl extends CommonService implements AbsenceService
{
    public function getArrayYearAbsence()
    {
        $min_year = Absence::selectRaw('min(year(from_date))')->first()['min(year(form_date))'];
        $max_year = Absence::selectRaw('max(year(to_date))')->first()['max(year(to_date))'];
        if(empty($min_year)){
            $array_year=[
                date('Y')=>date('Y')
            ];
        }else{
            $array_year = [
                (string)$min_year=>(string)$min_year
            ];
            for($i=1;$i<=($max_year-$min_year);$i++){
                $array_year = [
                    (string)($min_year+$i)=>(string)($min_year+$i)
                ];
            }
        }
        return $array_year;
    }
}