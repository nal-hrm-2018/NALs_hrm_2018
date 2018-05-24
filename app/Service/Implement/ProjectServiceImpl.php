<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 5/8/2018
 * Time: 9:18 AM
 */

namespace App\Service\Implement;


use App\Http\Requests\TeamEditRequest;
use App\Service\CommonService;
use App\Service\TeamService;
use App\Models\Team;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Role;
use Exception;
use App\Service\ProjectService;
use App\Models\Process;
class ProjectServiceImpl extends CommonService
    implements ProjectService
{


    public function getProcessbetweenDate($id, $start_date_process, $end_date_process)
    {
        $query = Process::query();
        $query->where('employee_id', $id);
        $query->whereNotExists(function ($query) use ($end_date_process) {
            $query->where('start_date', '>=', $end_date_process);
        });
        $query->whereNotExists(function ($query) use ($start_date_process) {
            $query
                ->where('end_date', '<=', $start_date_process);
        });
        return $query;
//        $x = $query->toSql();
    }

    public function addProject($request)
    {
        return false;
    }
}