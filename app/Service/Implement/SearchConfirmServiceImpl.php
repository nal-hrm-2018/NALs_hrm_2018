<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 4/18/2018
 * Time: 10:07 PM
 */

namespace App\Service\Implement;


use App\Models\Confirm;
use App\Models\Process;
use App\Models\TempListConfirm;
use App\Service\SearchConfirmService;
use App\Service\CommonService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchConfirmServiceImpl extends CommonService implements SearchConfirmService
{

    public function searchConfirm($request, $id)
    {
        $query = Process::select('processes.*')->distinct('processes.id');

        $params['search'] = [
            'employee_name' => !empty($request->employee_name) ? $request->employee_name : '',
            'email' => !empty($request->email) ? $request->email : '',
            'project_id' => !empty($request->project_id) ? $request->project_id : '',
            'absence_type' => !empty($request->absence_type) ? $request->absence_type : '',
            'from_date' => !empty($request->from_date) ? $request->from_date : '',
            'to_date' => !empty($request->to_date) ? $request->to_date : '',
            'absence_time' => !empty($request->absence_time) ? $request->absence_time : '',
        ];
        foreach ($params as $key => $value) {
            $employee_name = $value['employee_name'];
            $email = $value['email'];
            $project_id = $value['project_id'];
            $absence_type = $value['absence_type'];
            $from_date = $value['from_date'];
            $to_date = $value['to_date'];
            $absence_time = $value['absence_time'];
        }
        // $query->join('absences', 'absences.id', '=', 'processes.absence_id')
        //     ->join('employees', 'employees.id', '=', 'absences.employee_id');
//            ->join('processes', 'processes.employee_id', '=', 'employees.id')
//            ->join('projects', 'projects.id', '=', 'processes.project_id');
        if (!empty($employee_name)) {
            $query->where('employees.name', 'like', '%'.$employee_name.'%');
        }
        if (!empty($email)) {
            $query->where('employees.email', 'like', '%'.$email.'%');

        }
        if (!empty($project_id)) {
            $query->where('processes.project_id', '=', $project_id);

        }
        if (!empty($absence_type)) {
            $query->where('absences.absence_type_id', '=', $absence_type);

        }
        if (!empty($from_date) && !empty($to_date)) {
            $from_date .= ':00';
            $to_date .= ':00';
            $query->where('absences.from_date', '>=', $from_date);
            $query->where('absences.to_date', '<=', $to_date);
        } else if (!empty($from_date) && empty($to_date)) {
            $from_date .= ':00';
            $query->where('absences.from_date', '>=', $from_date);
        } else if (empty($from_date) && !empty($to_date)) {
            $to_date .= ':00';
            $query->where('absences.to_date', '<=', $to_date);
        }
        if (!empty($absence_time)) {
            $query->where('absence.absence_time_id', '=', $absence_time);
        }
        $query = $query->where('processes.employee_id', '=', $id)
            ->where('processes.project_id', '!=', null)
            ->where('processes.delete_flag', '=', 0)
            ->orderBy('processes.id', 'desc');
        return $query;
    }

    public function createTempTable($listValueOnPage, $tempTableName)
    {
        DB::unprepared(DB::raw("CREATE TEMPORARY TABLE ". $tempTableName ." AS(select * from processes where id=0)"));

        foreach ($listValueOnPage as $item){
            $temp_list = new TempListConfirm();
            $temp_list->id = $item->id;
            $temp_list->reason = $item->reason;
            $temp_list->updated_at = $item->updated_at;
            $temp_list->updated_by_employee = $item->updated_by_employee;
            $temp_list->created_at = $item->created_at;
            $temp_list->created_by_employee = $item->created_by_employee;
            $temp_list->delete_flag = $item->delete_flag;
            $temp_list->absence_id = $item->absence_id;
            $temp_list->employee_id = $item->employee_id;
            $temp_list->project_id = $item->project_id;
            $temp_list->save();
        }
    }



}