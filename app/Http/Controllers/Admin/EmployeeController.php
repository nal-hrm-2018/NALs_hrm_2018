<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\EmployeeAddRequest;
use App\Http\Requests\EmployeeEditRequest;
use App\Models\Employee;
use App\Models\Team;
use App\Models\Role;
use App\Models\Employee_types;
use DateTime;
class EmployeeController extends Controller
{
    public function getEmployeeAdd(){
    	$dataTeam = Team::select('id','name')->get()->toArray();
    	$dataRoles = Role::select('id','name')->get()->toArray();
    	$dataEmployeeTypes = Employee_types::select('id','name')->get()->toArray();
    	return view('admin.module.employees.add',['dataTeam' => $dataTeam, 'dataRoles' => $dataRoles, 'dataEmployeeTypes' => $dataEmployeeTypes]);
    }
    public function postEmployeeAdd(EmployeeAddRequest $request){
    	$objEmployee = Employee::select('email')->where('email','like',$request -> email)->get()->toArray();
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
    	if($objEmployee != null){ 
    		return redirect('employee') -> with(['msg_fail' => 'Add failed!!!Email already exists']);
    	}else{
    		$employee ->save();
    		return redirect('employee')->with(['msg_success' => 'Account successfully created']);
    	}
    }
    public function getEmployeeEdit($id){
        $objEmployee = Employee::findOrFail($id)->toArray();
        $dataTeam = Team::select('id','name')->get()->toArray();
        $dataRoles = Role::select('id','name')->get()->toArray();
        $dataEmployeeTypes = Employee_types::select('id','name')->get()->toArray();
        return view('admin.module.employees.edit',['objEmployee' => $objEmployee,'dataTeam' => $dataTeam, 'dataRoles' => $dataRoles, 'dataEmployeeTypes' => $dataEmployeeTypes]);
    }
    public function postEmployeeEdit(EmployeeEditRequest $request, $id){
        $objEmployee = Employee::select('email')->where('email','like',$request -> email)->where('id','<>',$request -> id)->get()->toArray();
        $employee = Employee::find($id);
        $employee -> email = $request -> email;
        $employee -> name = $request -> name;
        $employee -> birthday = $request -> birthday;  
        $employee -> gender = $request -> gender;
        $employee -> mobile = $request -> mobile;
        $employee -> address = $request -> address;
        $employee -> marital_status = $request -> marital_status;
        $employee -> startwork_date = $request -> startwork_date;
        $employee -> endwork_date = $request -> endwork_date;
        $employee -> company = $request -> company;
        $employee -> employee_type_id = $request -> employee_type_id;
        $employee -> teams_id = $request -> teams_id;
        $employee -> roles_id = $request -> roles_id;
        $employee -> updated_at = new DateTime();
        if($objEmployee != null){
            return redirect('employee') -> with(['msg_fail' => 'Edit failed!!! Email already exists']);
        }else{
            $employee ->save();
            return redirect('employee') -> with(['msg_success' => 'Account successfully edited']);
        }
    }
}
