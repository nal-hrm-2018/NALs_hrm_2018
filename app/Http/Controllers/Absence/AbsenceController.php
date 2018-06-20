<?php

namespace App\Http\Controllers\Absence;

use App\Http\Controllers\Controller;
use App\Models\Employee;

class AbsenceController extends Controller
{
    public function edit($id)
    {
        $employee = Employee::where('delete_flag', 0)->where('is_employee',1)->find($id);
        if ($employee == null) {
            return abort(404);
        }
        $objEmployee = Employee::select('employees.*', 'teams.name as team_name')
            ->join('teams', 'employees.team_id', '=', 'teams.id')
            ->where('employees.delete_flag', 0)->findOrFail($id)->toArray();

        $objPO = Employee::SELECT('employees.name as PO_name', 'projects.name as project_name')
            ->JOIN('processes', 'processes.employee_id', '=', 'employees.id')
            ->JOIN('projects', 'processes.project_id', '=', 'projects.id')
            ->JOIN('roles', 'processes.role_id', '=', 'roles.id')
            ->whereIn('processes.project_id', function($query) use($id)
            {
                $query->select('project_id')
                    ->from('processes')
                    ->where('employee_id','=',$id);
            })
            ->WHERE('employees.delete_flag', '=', 0)
            ->WHERE('roles.name', 'like', 'po')
            ->get()->toArray();

        return view('formVangNghi', ['objPO' => $objPO,'objEmployee' => $objEmployee]);
    }
}
