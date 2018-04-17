<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;
use App\Models\Team;
use App\Models\Role;
use App\Models\Employee_type;
use DateTime;
class EmployeeController extends Controller
{
    public function getEmployeeAdd(){
    	$dataTeam = Team::select('id','name')->get()->toArray();
    	$dataRoles = Role::select('id','name')->get()->toArray();
    	$dataEmployeeTypes = Employee_type::select('id','name')->get()->toArray();
    	return view('admin.module.employees.add',['dataTeam' => $dataTeam, 'dataRoles' => $dataRoles, 'dataEmployeeTypes' => $dataEmployeeTypes]);
    }
    public function postEmployeeAdd(EmployeeRequest $request){
    	$ObjEmployee = Employee::select('email')->where('email','like',$request -> email)->get()->toArray();
    	$employee = new Employee;
    	$employee -> email = $request -> email;
    	$employee -> password = bcrypt($request -> password);
    	$employee -> name = $request -> name;
    	$employee -> birthday = $request -> birthday;  
    	$employee -> gender = $request -> gender;
    	$employee -> mobile = $request -> mobile;
    	$employee -> address = $request -> address;
    	$employee -> marital_status = $request -> marital_status;
    	$employee -> startwork_date = $request -> startwork_date;
    	$employee -> endwork_date = $request -> endwork_date;
    	$employee -> is_employee = 1;
    	$employee -> company = $request -> company;
    	$employee -> employee_type_id = $request -> employee_type_id;
    	$employee -> teams_id = $request -> teams_id;
    	$employee -> roles_id = $request -> roles_id;
    	$employee -> created_at = new DateTime();
    	$employee -> delete_flag = 1;
    	if($ObjEmployee != null){
    		return redirect() -> route('getEmployeeAdd')->with(['msg_fail' => 'Email already exists']);
    	}else{
    		$employee ->save();
    		return redirect() -> route('login')->with(['msg_success' => 'Account successfully created']);
    	}
    }
}
