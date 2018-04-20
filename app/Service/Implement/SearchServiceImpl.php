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

    public function search(CommonRequest $request)
    {
        $query = Process::query();

        if (!empty($request->get('id'))){
            $query
                ->whereHas('employee', function ($query) use($request) {
                    $query->where("id", '=', $request->get('id'));
                });
        }

        if (!empty($request->get('project_name')) or !empty($request->get('project_status'))) {
            $query
                ->whereHas('project', function ($query) use ($request) {
                    if (!empty($request->get('project_name'))) {
                        $query->where("name", 'like', '%' . $request->get('project_name') . '%');
                    }
                    if (!empty($request->get('project_status'))) {
                        $query->where("status", 'like', '%' . $request->get('project_status') . '%');
                    }
                });
        }
        if (!empty($request->get('role'))) {
            $query
                ->whereHas('role', function ($query) use ($request) {
                    $query->where("name", 'like', '%' . $request->get('role') . '%');
                });

        }

        if (!empty($request->get('start_date'))) {
            $query->Where('start_date', '=', $request->get('start_date'));
        }
        if (!empty($request->get('end_date'))) {
            $query->Where('end_date', '=', $request->get('end_date'));
        }

        return $query;
    }
}