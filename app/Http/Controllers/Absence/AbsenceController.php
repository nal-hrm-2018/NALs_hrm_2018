<?php

namespace App\Http\Controllers\Absence;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\AbsenceStatus;
use App\Models\AbsenceType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AbsenceController extends Controller
{
    public function __construct(){

    }
    public function index(Request $request){

    }

    public function create(Request $request)
    {

    }

    public function store(Request $request){

    }
    public function show($id, Request $request){

    }
    public function edit($id){
        $employee = Employee::where('delete_flag', 0)->where('is_employee', 1)->find($id);
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
            ->whereIn('processes.project_id', function ($query) use ($id)  {
                $query->select('project_id')
                    ->from('processes')
                    ->where('employee_id', '=', $id)
                    ->where(function($query1)  {
                        $curDate= date_create(Carbon::now()->format('Y-m-d'));
                        $dayBefore = ($curDate)->modify('-15 day')->format('Y-m-d');
                        $dayAfter = ($curDate)->modify('+15 day')->format('Y-m-d');
                        return $query1 ->where('processes.start_date', '>', $dayBefore)
                            ->orWhere('processes.end_date', '<', $dayAfter);
                    })
                ;
            })
            ->WHERE('employees.delete_flag', '=', 0)
            ->WHERE('roles.name', 'like', 'po')
            ->get()->toArray();

        return view('formVangNghi', ['objPO' => $objPO, 'objEmployee' => $objEmployee]);
    }
    public function update(Request $request, $id){

    }
    public function destroy($id, Request $request){

    }

    // function create by Quy.
    public function showListAbsence(){
        $getIdUserLogged = Auth::id();
        $getTeamOfUserLogged = Employee::find($getIdUserLogged);
        $getAllAbsenceType = AbsenceType::all();
        $getAllAbsenceStatus = AbsenceStatus::all();
        $getAllEmployeeByTeamUserLogged = Employee::where('team_id',$getTeamOfUserLogged->team_id)
        ->where('delete_flag',0)->where('is_employee',1);
        $allAbsenceByUserLogged = array();
        $allEmployeeByUserLogged = array();
        $allAbsenceNotNull = array();
        $allEmployeeNotNull = array();
        foreach ($getAllEmployeeByTeamUserLogged->get() as $addEmployee){
            array_push($allAbsenceByUserLogged, $addEmployee->absences);
            array_push($allEmployeeByUserLogged,$addEmployee);
        }
        foreach ($allAbsenceByUserLogged as $allEmployee){
            foreach ( $allEmployee as $element){
                if (!is_null($element)){
                    array_push($allAbsenceNotNull,$element);
                }
            }
        }
        foreach ($allEmployeeByUserLogged as $allEmployee){
            foreach ($allEmployee->absences as $element){
                if (!is_null($element)){
                    array_push($allEmployeeNotNull,$allEmployee);
                }
            }

        }
        foreach ($allEmployeeNotNull as $element ){

        }
        return view('absences.poteam', compact('allEmployeeNotNull','allAbsenceNotNull','getIdUserLogged','getAllAbsenceType','getAllAbsenceStatus'));
    }
}
