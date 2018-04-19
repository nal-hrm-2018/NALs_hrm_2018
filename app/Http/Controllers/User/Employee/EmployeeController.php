<?php
/**
 * Created by PhpStorm.
 * User: Ngoc Quy
 * Date: 4/16/2018
 * Time: 11:26 AM
 */

namespace App\Http\Controllers\User\Employee;


use App\Models\Employee;
use App\Models\EmployeeType;
use App\Models\Project;
use App\Models\Role;
use App\Models\Team;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::where('delete_flag','=',0)->get();
        return view('employee.list', compact('employees'));
    }

    public function create()
    {
        $dataTeam = Team::select('id','name')->get()->toArray();
        $dataRoles = Role::select('id','name')->get()->toArray();
        $dataEmployeeTypes = EmployeeType::select('id','name')->get()->toArray();
        return view('admin.module.employees.add',['dataTeam' => $dataTeam, 'dataRoles' => $dataRoles, 'dataEmployeeTypes' => $dataEmployeeTypes]);
    }

    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        //set employee info
        $employee = Employee::find($id);

        //set list project
        $processes = $employee->processes;

        //paginate list project
//        $processes = PaginationService::paginate($processes, 5);

        //set chart

        return view('employee.detail', compact('employee', 'processes'))->render();
    }

    public function edit(Employee $employee)
    {
        //
    }

    public function update(Request $request, Employee $employee)
    {
        //
    }

    public function destroy(Employee $employee)
    {
        //
    }



    public function getValueOfEmployee($id)
    {
        $currentEmployee = Employee::find($id);
        $projects = $currentEmployee->projects;
        foreach ($projects as $project)
        {
            $this->getValueOfProject($project, $currentEmployee, '');
        }
    }

    public function getValueOfProject(Project $project, Employee $currentEmployee, $currentMonth)
    {
        //x
        $income = $project->income;
        $estimateTime = $this->calculateTime($project->estimate_end_date, $project->start_date);
        $currentTime = $this->calculateTime('Y-m-d', $project->start_date);
        if($project->end_date == null){
            $income = ($income / $estimateTime) * $currentTime;
        }

        //y
        $processes = $project->processes;
        $powerAllEmployeeOnProject = 0;
        foreach ($processes as $process){
            if($process->end_date == null){
                $powerAllEmployeeOnProject += $this->calculateTime('Y-m-d', $process->start_date) * $process->man_power;
            }
        }

        //z
        if($currentEmployee->processes->where('projects_id', $project->id)->end_date == null){

        } else {

        }
    }

    public function calculateTime($time1, $time2)
    {
        return (strtotime(date($time1))- strtotime(date($time2)))/(60*60*24);
    }
    public function searchCommonInList(Request $request){
        $query = Employee::query();

        $query->with(['team', 'role']);

        if ($request->input('role') != null ){
            $query
                ->whereHas('role', function ($query) use ($request) {
                    $query->where("name", 'like', '%'.$request->input('role').'%');
                });
        }
        if ($request->input('name') != null ){
                    $query->orWhere('name', 'like', '%'.$request->name.'%');
        }
        if ($request->id != null){
                    $query->orWhere('id', '=', $request->id);
        }
        if ($request->team != null) {
            $query
                ->whereHas('team', function ($query) use ($request) {
                    $query->where("name", 'like', '%'.$request->input('team').'%');
                });
        }
        if ($request->email != null) {
            $query->orWhere('email','like','%'.$request->email.'%');
        }
        if ($request->status != null) {
            $query->orWhere('work_status','like','%'.$request->status.'%');
        }
        $employeesSearch = $query->get();
        return view('employee.list')->with("employees", $employeesSearch);
    }

}