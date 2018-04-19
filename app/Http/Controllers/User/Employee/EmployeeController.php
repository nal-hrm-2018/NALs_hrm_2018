<?php
/**
 * Created by PhpStorm.
 * User: Ngoc Quy
 * Date: 4/16/2018
 * Time: 11:26 AM
 */

namespace App\Http\Controllers\User\Employee;

/*require 'vendor/autoload.php';
*/
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\EmployeeAddRequest;
use App\Http\Requests\EmployeeEditRequest;
use App\Models\Employee;
use App\Models\Team;
use App\Models\Role;
use App\Models\Employee_type;
use DateTime;
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
use Excel;
use Input;
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
        $dataEmployeeTypes = Employee_type::select('id','name')->get()->toArray();
        return view('admin.module.employees.add',['dataTeam' => $dataTeam, 'dataRoles' => $dataRoles, 'dataEmployeeTypes' => $dataEmployeeTypes]);
    }

    public function store(EmployeeAddRequest $request) 
    {
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
        $employee -> team_id = $request -> team_id;
        $employee -> role_id = $request -> role_id;
        $employee -> created_at = new DateTime();
        $employee -> delete_flag = 0;
        if($objEmployee != null){ 
            return redirect('employee') -> with(['msg_fail' => 'Add failed!!!Email already exists']);
        }else{
            $employee ->save();
            return redirect('employee')->with(['msg_success' => 'Account successfully created']);
        }
    }

    public function show(Employee $employee)
    {
        //
    }

    public function edit($id)
    {
        $objEmployee = Employee::findOrFail($id)->toArray();
        $dataTeam = Team::select('id','name')->get()->toArray();
        $dataRoles = Role::select('id','name')->get()->toArray();
        $dataEmployeeTypes = Employee_type::select('id','name')->get()->toArray();
        return view('admin.module.employees.edit',['objEmployee' => $objEmployee,'dataTeam' => $dataTeam, 'dataRoles' => $dataRoles, 'dataEmployeeTypes' => $dataEmployeeTypes]);
    }

    public function update(EmployeeEditRequest $request, $id)
    {
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
        $employee -> team_id = $request -> team_id;
        $employee -> role_id = $request -> role_id;
        $employee -> updated_at = new DateTime();
        if($objEmployee != null){
            return redirect('employee') -> with(['msg_fail' => 'Edit failed!!! Email already exists']);
        }else{
            $employee ->save();
            return redirect('employee') -> with(['msg_success' => 'Account successfully edited']);
        }
    }

    public function destroy($id)
    {
        return redirect('employee');
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

    public function import_csvxxx(){  
        Excel::load(Input::file('csv_file'), function($reader) {
            $reader->each(function($sheet){
                Employee::firstOrCreate($sheet->toArray());
                return $sheet;
            });
        });
        return redirect('employee') -> with(['msg_success' => 'Import successfully']);;
    }
/*
        ALL DEBUG 
        echo "<pre>";
        print_r($employees);
        die;
        var_dump(): user in view;
        dd(); view array
*/
}