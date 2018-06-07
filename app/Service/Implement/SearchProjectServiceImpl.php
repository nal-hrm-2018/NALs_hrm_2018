<?php
/**
 * Created by PhpStorm.
 * User: Ngoc Quy
 * Date: 5/23/2018
 * Time: 8:48 AM
 */

namespace App\Service\Implement;


use App\Models\Project;
use App\Models\Role;
use App\Service\SearchProjectService;
use Illuminate\Http\Request;

class SearchProjectServiceImpl implements SearchProjectService
{

    public function searchProject(Request $params)
    {

        $query = Project::query();
        $poRole = Role::select('id')
            ->where('name', 'PO')->first();

        if (!empty($params['project_id'])) {
            $query
                ->where("id", 'like', '%' . $params['project_id'] . '%');
        }
        if (!empty($params['name'])) {
            $query
                ->where("name", 'like', '%' . $params['name'] . '%');
        }
        if (!empty($params['po_name'])) {
            $query
                ->whereHas('processes', function ($query) use ($params, $poRole) {
                    $query->where("role_id", '=', $poRole->id)
                        ->whereHas('employee', function ($query) use ($params) {
                            $query->where("name", 'like', '%' . $params['po_name'] . '%');
                        });
                });
        }
        if ((!is_null($params['number_from'])) && (!is_null($params['number_to']))) {

            $number_form = $params['number_from'] * 1;
            $number_to = $params['number_to'] * 1;

            $query->whereRaw('(select count(distinct processes.employee_id) from processes where processes.project_id = projects.id and processes.delete_flag = 0) >='.$number_form.'')
            ->whereRaw('(select count(distinct processes.employee_id) from processes where processes.project_id = projects.id and processes.delete_flag = 0) <='.$number_to.'');
        }
        else if ( !is_null($params['number_from']) ) {
            $number_form = $params['number_from'] * 1;

            $query->whereRaw('(select count(distinct processes.employee_id) from processes where processes.project_id = projects.id and processes.delete_flag = 0) >='.$number_form.'');
        }
        else if (!is_null($params['number_to'])) {
            $number_to = $params['number_to'] * 1;

            $query->whereRaw('(select count(distinct processes.employee_id) from processes where processes.project_id = projects.id and processes.delete_flag = 0) <='.$number_to.'');

        }
        /*
        * search by Employee Name in project
        */
        if (!empty($params['name_member'])) {
            $query
                ->whereHas('processes', function ($query) use ($params, $poRole) {
                    $query
                        ->whereHas('employee', function ($query) use ($params) {
                            $query->where("name", 'like', '%' . $params['name_member'] . '%');
                        });
                });
        }
        /*
         * search date in project
         */
        if (!is_null($params['project_date_real_from']) && !is_null($params['project_date_real_to'])) {

            $query->where("start_date", ">=", $params['project_date_real_from']);
            $query->where("end_date", "<=", $params['project_date_real_to']);
        } elseif (!is_null($params['project_date_real_from'])) {
            $query->where("start_date", ">=", $params['project_date_real_from']);
        } elseif (!is_null($params['project_date_real_to'])) {
            $query->where("end_date", "<=", $params['project_date_real_to']);
        }

        /*
         * search date real in project
         */
        if (!is_null($params['project_date_from']) && !is_null($params['project_date_to'])) {

            $query->where("estimate_start_date", ">=", $params['project_date_from']);
            $query->where("estimate_end_date", "<=", $params['project_date_to']);
        } elseif (!is_null($params['project_date_from'])) {
            $query->where("estimate_start_date", ">=", $params['project_date_from']);
        } elseif (!is_null($params['project_date_to'])) {
            $query->where("estimate_end_date", "<=", $params['project_date_to']);
        }
        /*
        * search by Status in project
        */
        if (!empty($params['status'])) {
//            $status = $params['status'] * 1;
//            $query->where("status_id", $status);
            $query
                ->whereHas('status', function ($query) use ($params) {
                    $query->where("name", 'like', '%' . $params['status'] . '%');
                });
        }


        $query->where('delete_flag', 0);
        return $query;

    }
}