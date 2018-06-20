<?php

namespace App\Http\Controllers\Absence;

use App\Http\Controllers\Controller;
use App\Models\Confirm;
use App\Models\Employee;
use App\Absence\AbsenceService;
use App\Models\AbsenceStatus;
use App\Models\AbsenceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsenceController extends Controller
{
    public function __construct(){

    }
    public function index(Request $request){
    	$abc = new AbsenceService();
    	dd($abc->soNgayNghiPhep(1,2018,3, 2));
    	dd($abc->soNgayDuocNghiPhep(1,2017));
        return view('vangnghi.list');
    }

    public function create()
    {

    }

    public function store(Request $request){

    }
    public function show($id, Request $request){

    }
    public function edit($id){

    }
    public function update(Request $request, $id){

    }
    public function destroy($id, Request $request){

    }

    // function create by Quy.
    public function showListAbsence(){
        $getIdUserLogged = Auth::id();
        $getAllAbsenceInConfirm = Confirm::where('employee_id',$getIdUserLogged)->get();
        /*$getTeamOfUserLogged = Employee::find($getIdUserLogged);
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
                if (!is_null($element) ){
                    array_push($allEmployeeNotNull,$allEmployee);
                }
            }
        }*/

//        return view('absences.poteam', compact('allEmployeeNotNull','allAbsenceNotNull','getIdUserLogged','getAllAbsenceType','getAllAbsenceStatus'));
        return view('absences.poteam', compact('getAllAbsenceInConfirm'));
    }
    public function denyPOTeam(Request $request){

        return redirect()->route('absence-po');
    }
}
