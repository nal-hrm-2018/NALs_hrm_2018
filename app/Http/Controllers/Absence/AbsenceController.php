<?php

namespace App\Http\Controllers\Absence;

use App\Http\Controllers\Controller;
use App\Models\AbsenceStatus;
use App\Models\AbsenceType;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AbsenceController extends Controller
{
    public function __construct(){

    }
    public function index(Request $request){

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
        $getTeamOfUserLogged = Employee::find($getIdUserLogged);
        $getAllAbsenceType = AbsenceType::all();
        $getAllAbsenceStatus = AbsenceStatus::all();
        $getAllEmployeeByTeamUserLogged = Employee::where('team_id',$getTeamOfUserLogged->team_id)
        ->where('delete_flag',0)->where('is_employee',1);
        foreach ($getAllEmployeeByTeamUserLogged->get() as $test){
            dd($test->absences);
        }

        return view('absences.poteam', compact('getIdUserLogged','getAllAbsenceType','getAllAbsenceStatus'));
    }
}
