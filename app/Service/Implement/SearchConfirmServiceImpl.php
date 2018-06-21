<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 4/18/2018
 * Time: 10:07 PM
 */

namespace App\Service\Implement;


use App\Models\Confirm;
use App\Service\SearchConfirmService;
use App\Service\CommonService;

class SearchConfirmServiceImpl extends CommonService implements SearchConfirmService
{

    public function searchConfirm($request)
    {
        $query = Confirm::select('confirms.*')->distinct('confirms.id');



        $params['search'] = [
            'employee_name' => !empty($request->employee_name) ? $request->employee_name : '',
            'email' => !empty($request->email) ? $request->email : '',
            'project_id' => !empty($request->project_id) ? $request->project_id : '',
            'absence_type' => !empty($request->absence_type) ? $request->absence_type : '',
            'from_date' => !empty($request->from_date) ? $request->from_date : '',
            'to_date' => !empty($request->to_date) ? $request->to_date : '',
        ];
        foreach ($params as $key => $value) {
            $employee_name = $value['employee_name'];
            $email = $value['email'];
            $project_id = $value['project_id'];
            $absence_type = $value['absence_type'];
            $from_date = $value['from_date'];
            $to_date = $value['to_date'];
        }
        $query->join('absences', 'absences.id', '=', 'confirms.absence_id')
            ->join('employees', 'employees.id', '=', 'absences.employee_id')
            ->join('processes', 'processes.employee_id', '=', 'employees.id')
            ->join('projects', 'projects.id', '=', 'processes.project_id');
        if (!empty($employee_name)) {
            $query->where('employees.name', 'like', '%'.$employee_name.'%');
        }
        if (!empty($email)) {
            $query->where('employees.email', 'like', '%'.$email.'%');

        }
        if (!empty($project_id)) {
            $query->where('projects.id', '=', $project_id);

        }
        if (!empty($absence_type)) {
            $query->where('absences.absence_type_id', '=', $absence_type);

        }
//                dd($query->toSql());
        return $query;
    }


}