<?php
/**
 * Created by PhpStorm.
 * User: Ngoc Quy
 * Date: 4/16/2018
 * Time: 11:26 AM
 */

namespace App\Http\Controllers\User\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\EmployeeAddRequest;
use App\Http\Requests\EmployeeEditRequest;
use App\Models\Employee;
use App\Models\Team;
use App\Models\Role;
use App\Models\EmployeeType;
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
        $dataEmployeeTypes = EmployeeType::select('id','name')->get()->toArray();
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
            \Session::flash('msg_fail', 'Add failed!!! Email already exists!!!');
            return redirect('employee/create') -> with(['employee' => $employee]);
        }else{
            $employee ->save();
            \Session::flash('msg_fail', 'Account successfully created!!!');
            return redirect('employee');
        }
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

    public function edit($id)
    {
        $objEmployee = Employee::findOrFail($id)->toArray();
        $dataTeam = Team::select('id','name')->get()->toArray();
        $dataRoles = Role::select('id','name')->get()->toArray();
        $dataEmployeeTypes = EmployeeType::select('id','name')->get()->toArray();

        return view('admin.module.employees.edit',['objEmployee' => $objEmployee,'dataTeam' => $dataTeam, 'dataRoles' => $dataRoles, 'dataEmployeeTypes' => $dataEmployeeTypes]);
    }

    public function update(EmployeeEditRequest $request, $id)
    {
        $objEmployee = Employee::select('email')->where('email','like',$request -> email)->where('id','<>',$id)->get()->toArray();
        $pass = $request -> password;
        $employee = Employee::find($id);
        $employee -> email = $request -> email;
        if($pass != null){
            if(strlen($pass) < 6){
                return back()->with(['minPass' => 'The Password must be at least 6 characters.' , 'employee'=>$employee]);
            }else{
                $employee -> password = bcrypt($request -> password);
            }
        }  
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
            \Session::flash('msg_fail', 'Edit failed!!! Email already exists!!!');
            return back()->with(['employee'=>$employee]);
            // return redirect('employee/'.$id.'/edit') -> with(['msg_fail' => 'Edit failed!!! Email already exists']);
        }else{
            $employee ->save();
            \Session::flash('msg_success', 'Account successfully edited!!!');
            return redirect('employee');    
        }
    }

    public function destroy($id, Request $request)
    {
        if ( $request->ajax() ) {
            $employees = Employee::where('id',$id)->where('delete_flag',0)->first();
            $employees->delete_flag = 1;
            $employees->save();

            return response(['msg' => 'Product deleted', 'status' => 'success','id'=> $id]);
        }
        return response(['msg' => 'Failed deleting the product', 'status' => 'failed']);
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
        return (strtotime(date($time1)) - strtotime(date($time2))) / (60 * 60 * 24);
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

    public function import_csv(Request $request){  
        /*Excel::load(Input::file('csv_file'), function($reader) {
            $reader->each(function($sheet){
                Employee::firstOrCreate($sheet->toArray());
                return $sheet;
            });
        });
        return redirect('employee') -> with(['msg_success' => 'Import successfully']);;*/
        if($request->hasFile('csv_file')){
            $path = $request->file('csv_file')->getRealPath();
            $data = Excel::load($path)->get();
            if($data->count()){
                foreach ($data as $key => $value) {
                    $employee_list[] = [
                        'email' => $value -> email,
                        'name' => $value -> name,
                        'password' => $value -> password,
                        'remember_token' => $value -> remember_token,
                        'birthday' => $value -> birthday,
                        'gender' => $value -> gender,
                        'mobile' => $value -> mobile,
                        'address' => $value -> address,
                        'marital_status' => $value -> marital_status,
                        'startwork_date' => $value -> startwork_date,
                        'endwork_date' => $value -> endwork_date,
                        'is_employee' => $value -> is_employee,
                        'company' => $value -> company,
                        'employee_type_id' => $value -> employee_type_id,
                        'team_id' => $value -> team_id,
                        'role_id' => $value -> role_id,
                        'updated_at' => $value -> updated_at,
                        'delete_flag' => $value -> delete_flag    
                    ];
                }
                if(!empty($employee_list)){
                    Employee::insert($employee_list);
                    Session::flash('success','success');
                }
            }
        }else{
            \Session::flash('fail','fail');
        }
        return redirect('employee');
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