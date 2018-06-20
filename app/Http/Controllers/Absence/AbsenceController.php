<?php

namespace App\Http\Controllers\Absence;

use App\Http\Controllers\Controller;
<<<<<<< HEAD
use App\Models\Employee;
use App\Absence\AbsenceService;
class AbsenceController extends Controller
{
    public function index()
    {
    	$abc = new AbsenceService();
    	/*dd($abc->soNgayNghiPhep(1,2017,0));
    	dd($abc->soNgayDuocNghiPhep(1,2017));*/
        return view('vangnghi.list');
=======
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
>>>>>>> dfb0a0eea2cb6caf184af733ccac38f2acefb4f2
    }
}
