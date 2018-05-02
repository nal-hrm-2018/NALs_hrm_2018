<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 4/18/2018
 * Time: 10:07 PM
 */

namespace App\Service\Implement;


use App\Http\Requests\CommonRequest;
use App\Service\SearchService;
use App\Models\Process;
use App\Service\CommonService;
use Illuminate\Support\Facades\Auth;

class SearchServiceImpl extends CommonService implements SearchService
{

    public function search($request)
    {
        $query = Process::query();

        if (!empty($request['id'])) {
            $query
                ->whereHas('employee', function ($query) use ($request) {
                    $query->where("id", '=', $request['id']);
                });
        }

        if (!empty($request['project_name']) or !empty($request['project_status'])) {
            $query
                ->whereHas('project', function ($query) use ($request) {
                    if (!empty($request['project_name'])) {
                        $query->where("name", 'like', '%' . $request['project_name'] . '%');
                    }
                    if (!empty($request['project_status'])) {
                        $query->whereHas('status', function ($query) use ($request) {
                            $query->where("status_id",'=', $request['project_status']);
                        });
                    }
                });
        }
        if (!empty($request['role'])) {
            $query
                ->whereHas('role', function ($query) use ($request) {
                    $query->where("id", '=', $request['role']);
                });
        }

        if (!empty($request['start_date'])) {
            $query->Where('start_date', '=', $request['start_date']);
        }
        if (!empty($request['end_date'])) {
            $query->Where('end_date', '=', $request['end_date']);
        }

        $s = $query->toSql();

        return $query;
    }
}