<?php

namespace App\Http\Controllers\User\Employee;

use App\Export\TemplateExport;
use App\Service\ChartService;
use App\Export\InvoicesExport;
use App\Service\SearchEmployeeService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeAddRequest;
use App\Models\Employee;
use App\Models\Team;
use App\Models\Role;
use App\Models\EmployeeType;
use App\Models\ContractualType;
use App\Models\EmployeeTeam;
use App\Models\PermissionEmployee;
use App\Models\PermissionRole;
use App\Models\Overtime;
use App\Models\OvertimeStatus;
use App\Models\Absence;
use DateTime;
use App\Service\SearchService;
use App\Http\Requests\SearchRequest;
use Illuminate\Support\Facades\Input;
use App\Models\Status;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\EmployeeEditRequest;
use App\Import\ImportFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    /**
     * @var SearchEmployeeServiceProvider
     */
    private $searchEmployeeService;
    protected $searchService;
    private $chartService;
    private $objmEmployeePermission;

    public function __construct(SearchService $searchService, SearchEmployeeService $searchEmployeeService, ChartService $chartService,PermissionEmployee $objmEmployeePermission
    )
    {
        $this->searchService = $searchService;
        $this->searchEmployeeService = $searchEmployeeService;
        $this->chartService = $chartService;
        $this->objmEmployeePermission=$objmEmployeePermission;
    }

    public function index(Request $request)
    {
//        echo $request['number_record_per_page']; die();
        $status = [0=> trans('employee.profile_info.status_active'), 1=>trans('employee.profile_info.status_quited'),2=> trans('employee.profile_info.status_expired')];
        $roles = Role::select('id', 'name')->where('delete_flag', 0)->get();
        $teams = Team::select('id', 'name')->where('delete_flag', 0)->get();
        if (!isset($request['number_record_per_page'])) {
            $request['number_record_per_page'] = config('settings.paginate');
        }
        $employees = $this->searchEmployeeService->searchEmployee($request)->orderBy('id', 'asc')->with('overtime.status');
        $employees->get();
        $employees = $employees->paginate($request['number_record_per_page']);
        $employees->setPath('');
        $year = date('Y');
        $year_start = $year.'-01-01';
        $year_end = $year.'-12-31';
        foreach($employees as $val){
            $s = 0;
            if(count($val->overtime)){
                foreach($val->overtime as $ot){
                    if(($ot->status->name == 'Accepted' || $ot->status->name == 'Rejected') && strtotime($ot->date) > strtotime($year_start) && strtotime($ot->date) < strtotime($year_end)){
                        $s += $ot->correct_total_time;
                    }
                }
            }
            // $data = json_decode($data,true); 
            unset($val->overtime );
            $val->overtime = $s;
        }
        $param = (Input::except(['page','is_employee']));
        $id=Auth::user()->id;
        $overtime_status = OvertimeStatus::select('id')->where('name', 'Not yet')->first();
        $employee_permission=$this->objmEmployeePermission->permission_employee($id);
        return view('employee.list', compact('employees','status', 'roles', 'teams', 'param','employee_permission'));
 //       return view('employee.newlist', compact('employees','status', 'roles', 'teams', 'param','employee_permission'));
    }

    public function create()
    {
        $dataTeam = Team::select('id', 'name')->where('delete_flag', 0)->get()->toArray();
        $dataRoles = Role::select('id', 'name')->where('delete_flag', 0)->get()->toArray();
        $contractualTypes = ContractualType::select('id', 'name')->where('delete_flag', 0)->get()->toArray();
        return view('employee.add', ['dataTeam' => $dataTeam, 'dataRoles' => $dataRoles, 'contractualTypes' => $contractualTypes]);
    }

    public function store(EmployeeAddRequest $request)
    {
        $employee = new Employee;
        $employee->email = $request->email;
        $employee->password = bcrypt($request->password);
        $employee->name = preg_replace('/\s+/', ' ',$request->name);
        $employee->birthday = $request->birthday;
        $employee->gender = $request->gender;
        $employee->mobile = $request->mobile;
        $employee->address = $request->address;
        $employee->marital_status = $request->marital_status;
        $employee->startwork_date = $request->startwork_date;
        // $employee->endwork_date = $request->endwork_date;
        //upload hinh from hunganh
        if($request->file('picture')){
            $file = Input::file('picture');
            if(strlen($file) > 0){
                $picture= $file->getClientOriginalName();
                $file->move('avatar',$picture);
                $employee->avatar = $picture;
            }
        }

        $date = new DateTime;
        $date = $date->format('Y-m-d H:i:s');
        // if ($employee->endwork_date) {           
        //     if(strtotime($employee->endwork_date) < strtotime($date)){
        //         $employee->work_status = 1;
        //     }else{
        //         $employee->work_status = 0;
        //     }
        // } else {
        //    $employee->work_status = 0;
        // }
        $employee->is_employee = 1;
        $employee->contractual_type_id = $request->contractual_type_id;
        if ($employee->contractual_type_id) {
            // this is temporary solution
            // $employee->type = {(1,internship),(2,FullTime),(3,parttime),(4,contractual),(5,probationary)}
            // $employee->contract = {(1, internship),(2,probation),(3, 1-month),(4, 3-month),(4,indefinate),(5,parttime)} 
            switch ($employee->contractual_type_id) {
                case '1':
                    $employee->employee_type_id = 1;
                    break;
                case '2':
                    $employee->employee_type_id = 5;
                    break;
                case '3':
                    $employee->employee_type_id = 2;
                    break;
                case '4':
                    $employee->employee_type_id = 2;
                    break;
                case '5':
                    $employee->employee_type_id = 2;
                    break;
                case '6':
                    $employee->employee_type_id = 3;
                    break;
                
                default:
                    break;
            }
        }
        $employee->role_id = $request->role_id;
        $employee->created_at = new DateTime();
        $employee->delete_flag = 0;

        if($employee->save()){
            $id_employeeteam=$employee->id;
            
            foreach ($request['team_id'] as $teamid){
                $employeeteam = new EmployeeTeam;
                $employeeteam->team_id=$teamid;
                $employeeteam->employee_id=$id_employeeteam;
                $employeeteam->save();
            }
            $role_id = $request->role_id;
            $employee_permission = PermissionRole::where('role_id', $request->role_id)->get();
            foreach ($employee_permission as $permission){
                $PermissionEmployee = new PermissionEmployee;
                $PermissionEmployee->permission_id = $permission->permission_id;
                $PermissionEmployee->employee_id = $id_employeeteam;
                $PermissionEmployee->save(); 
            }
            \Session::flash('msg_success', trans('employee.msg_add.success'));
            return redirect('employee');
        }else{
            \Session::flash('msg_fail', trans('employee.msg_add.fail'));
            return back()->with(['employee' => $employee]);
        }
        
    }

    public function show($id, SearchRequest $request)
    {
        $data = $request->only([
                'project_name' => $request->get('project_name'),
                'role' => $request->get('role'),
                'start_date' => $request->get('start_date'),
                'end_date' => $request->get('end_date'),
                'project_status' => $request->get('project_status'),
                'number_record_per_page' => $request->get('number_record_per_page'),
                'is_employee' => $request->get('is_employee'),
            ]
        );
        $rest_absence = Employee::emp_absence($id)['remaining_this_year'];
        $active = $request->get('number_record_per_page');

        if ($active) {
            $active = 'project';
        } else {
            $active = 'basic';
        }

        if (!isset($data['number_record_per_page'])) {
            $data['number_record_per_page'] = config('settings.paginate');
        }

        $data['id'] = $id;

        $processes = $this->searchService->searchProcess($data)->orderBy('project_id', 'desc')->paginate($data['number_record_per_page']);

        $processes->setPath('');

        $param = (Input::except(['page','is_employee']));

        //set employee info
        $employee = Employee::where('delete_flag', 0)->where('is_employee', '1')->find($id);

        $roles = Role::where('delete_flag', 0)->orderBy('name', 'asc')->pluck('name', 'id')->toArray();

        $project_statuses = Status::orderBy('name', 'asc')->pluck('name', 'id')->toArray();


        if (!isset($employee)) {
            return abort(404);
        }

        //set chart
        $year = date('Y');
        $listValue = $this->chartService->getListValueOfMonth($employee, $year);

        //set list years
        $listYears = $this->chartService->getListYear($employee);

        $overtime = Overtime::select()
                    ->where('employee_id', $id)
                    ->WhereMonth(('date'), date('m'))
                    ->where('delete_flag', '=', 0)
                    ->whereHas('status',function($query) {
                        $query->where('name','Accepted')->orWhere('name','Rejected');
                    })
                    ->get()->sortBy('date');
        $normal = 0;
        $weekend = 0;
        $holiday = 0;
        foreach($overtime as $val){
            if($val->type->name == 'normal'){
                $normal += $val->correct_total_time;
            }elseif($val->type->name == 'weekend'){
                $weekend += $val->correct_total_time;
            }elseif($val->type->name == 'holiday'){
                $holiday += $val->correct_total_time;
            }
        }
        $time = ['normal' => $normal,'weekend' => $weekend,'holiday' => $holiday];
        $listAbsence = Absence::select('absence_statuses.name AS name_status','absence_types.name AS name_type','absence_time.name AS name_time',
            'absences.from_date','absences.to_date','absences.reason','absences.description','absences.id', 'absences.is_deny',
            'absences.absence_status_id')
            ->join('absence_types', 'absences.absence_type_id', '=', 'absence_types.id')
            ->join('absence_time', 'absences.absence_time_id', '=', 'absence_time.id')
            ->join('absence_statuses', 'absences.absence_status_id', '=', 'absence_statuses.id')
            ->where('absences.delete_flag', 0)
            ->where('absences.employee_id',$id)
            ->where(function($listAbsence)use($year){
                $listAbsence->whereYear('absences.from_date', $year)
                    ->orWhereYear('absences.to_date', $year);
            })
            ->orderBy('absences.id', 'desc')
            ->get();
        return view('employee.detail', compact(
            'overtime',
            'time',
            'employee',
            'processes',
            'listValue',
            'listYears',
            'roles',
            'param',
            'project_statuses',
            'active',
            'rest_absence',
            'listAbsence'))
            ->render();
    }

    public function edit($id)
    {
        $employee = Employee::where('delete_flag', 0)->where('is_employee',1)->find($id);
        if ($employee == null) {
            return abort(404);
        }
        $dataTeamAll = Team::select('id', 'name')->where('delete_flag', 0)->get()->toArray();
        $dataTeam = Employee::find($id);

        $objEmployee = Employee::where('delete_flag', 0)->findOrFail($id);
        $dataRoles = Role::select('id', 'name')->where('delete_flag', 0)->get()->toArray();
        $contractualTypes = ContractualType::select('id', 'name')->where('delete_flag', 0)->get()->toArray();
        return view('employee.edit', ['objEmployee' => $objEmployee, 'dataTeam' => $dataTeam, 'dataRoles' => $dataRoles, 'contractualTypes' => $contractualTypes ,'dataTeamAll' => $dataTeamAll]);
    }

    public function update(EmployeeEditRequest $request, $id)
    {
        // dd($request);
        $id_emp=Auth::user()->id;
        if($id_emp!=$id){
            if(!Auth::user()->hasRoleHR()){
                return redirect()->route('dashboard-user');
            }
        }
        $employee = Employee::where('delete_flag', 0)->where('is_employee',1)->find($id);
        if ($employee == null) {
            return abort(404);
        }
        if(Auth::user()->hasRoleHR()){
            $employee->email = $request->email;
            $employee->startwork_date = $request->startwork_date;
            $employee->endwork_date = $request->endwork_date;
            $employee->role_id = $request->role_id;
            $employee->contractual_type_id = $request->contractual_type_id;
        }

        $employee->name = preg_replace('/\s+/', ' ',$request->name);
        $employee->birthday = $request->birthday;
        $employee->gender = $request->gender;
        $employee->mobile = $request->mobile;
        $employee->address = preg_replace('/\s+/', ' ',$request->address);
        $employee->marital_status = $request->marital_status;
        $employee->contractual_type_id = $request->contractual_type_id;
        if ($employee->contractual_type_id) {
            // this is temporary solution
            // $employee->type = {(1,internship),(2,FullTime),(3,parttime),(4,contractual),(5,probationary)}
            // $employee->contract = {(1, internship),(2,probation),(3, 1-month),(4, 3-month),(4,indefinate),(5,parttime)} 
            switch ($employee->contractual_type_id) {
                case '1':
                    $employee->employee_type_id = 1;
                    break;
                case '2':
                    $employee->employee_type_id = 5;
                    break;
                case '3':
                    $employee->employee_type_id = 2;
                    break;
                case '4':
                    $employee->employee_type_id = 2;
                    break;
                case '5':
                    $employee->employee_type_id = 2;
                    break;
                case '6':
                    $employee->employee_type_id = 3;
                    break;
                
                default:
                    break;
            }
        }
        
        if($request->file('picture')){
            $file = Input::file('picture');
            if(strlen($file) > 0){
                $picture= $file->getClientOriginalName();
                $file->move('avatar',$picture);
                $employee->avatar = $picture;
            }
        }
        $date = new DateTime;
        $date = $date->format('Y-m-d H:i:s');
        // if($employee->endwork_date){
        //      if(strtotime($employee->endwork_date) < strtotime($date)){
        //         $employee->work_status = 1;
        //     }else{
        //         $employee->work_status = 0;
        //     }
        // } else{
        //     $employee->work_status = 0;
        // }
       
        $id_NALs = Team::select('id')->where('name','NALs')->first();
        if(!$request->get('team_id')){
          $request->merge(['team_id' => $id_NALs]);
        } 
        
        $employee->updated_at = new DateTime();
        if ($employee->save()) {
            $employee = Employee::where('delete_flag', 0)->where('is_employee',1)->find($id);
            $employee->teams()->sync($request['team_id']);
            \Session::flash('msg_success', trans('employee.msg_edit.success'));
            return redirect()->route('employee.edit',compact('id'));
        } else {
            \Session::flash('msg_fail', trans('employee.msg_edit.fail'));
            return back()->with(['employee' => $employee]);
        }
    }
    public function editPass(Request $request, $id)
    {
        $employee = Employee::find(\Illuminate\Support\Facades\Auth::user()->id);
        $ojbEmployee = Employee::Where('id',$id)->first();
        $newPass = $request -> new_pass;
        $cfPass = $request -> cf_pass;
        if (\Illuminate\Support\Facades\Auth::user()->id == $id) {
            $oldPass = $request -> old_pass;
            if (!Hash::check($oldPass, $ojbEmployee->password)) {
                return back()->with(['error'=> trans('employee.valid_reset_password.incorrect_old_pass'), 'employee' => $ojbEmployee]);
            }
            if($newPass == $oldPass){
                return back()->with(['error' => trans('employee.valid_reset_password.repeat__pass'), 'employee' => $ojbEmployee]);
            }
        }
        if($newPass != $cfPass){
            return back()->with(['error' => trans('employee.valid_reset_password.match_confirm_pass'), 'employee' => $ojbEmployee]);
        }else{
            if (strlen($newPass) < 6) {
                return back()->with(['error' => trans('employee.valid_reset_password.min_new_pass'), 'employee' => $ojbEmployee]);
            }else {
                $ojbEmployee->password = bcrypt($newPass);
                $ojbEmployee->save();
                \Session::flash('msg_success', trans('employee.valid_reset_password.reset_success'));
                return redirect('employee/'.$ojbEmployee->id.'/edit');
            }
        }
    }


    public function destroy($id, Request $request)
    {
            $employees = Employee::where('id', $id)->where('delete_flag', 0)->first();
            $employees->delete_flag = 1;
            $employees->save();

//          \Session::flash('msg_success', trans('employee.msg_add.success'));
          //return redirect()->route('employee.index');
          return response(['msg' => 'Product deleted', 'status' => trans('common.delete.success'), 'id' => $id]);
    }


    public function showChart($id, Request $request)
    {
        $year = $request->year;
        $employee = Employee::find($id);
        $listValue = $this->chartService->getListValueOfMonth($employee, $year);
        return response(['listValue' => $listValue]);
    }


    public function postFile(Request $request)
    {
        $listError = "";
        if ($request->hasFile('myFile')) {
            $file = $request->file("myFile");
            if(5242880 < $file->getSize()){ 
                \Session::flash('msg_fail', trans('employee.valid5mb'));
                return redirect('employee');
            }           
            if ($file->getClientOriginalExtension('myFile') == "csv") {
                $nameFile = $file->getClientOriginalName('myFile');
                $file->move('files', $nameFile);

                $importFile = new ImportFile;

                $dataEmployees = $importFile->readFile(public_path('files/' . $nameFile));
                $num = $importFile->countCol(public_path('files/' . $nameFile));

                $templateExport = new TemplateExport;
                $colTemplateExport = $templateExport -> headings();

                $colError = $importFile->checkCol(public_path('files/' . $nameFile),count($colTemplateExport));
                if ($colError != null) {
                    if (file_exists(public_path('files/' . $nameFile))) {
                        unlink(public_path('files/' . $nameFile));
                    }
                    return view('employee.list_import', ['urlFile' => public_path('files/' . $nameFile), 'colError' => $colError, 'listError' => $listError]);
                }
                $row = count($dataEmployees) / $num;
                $listError .= $importFile->checkEmail($dataEmployees, $row, $num);
                $listError .= $importFile->checkFileEmployee($dataEmployees, $num);

                if ($listError != null) {
                    if (file_exists(public_path('files/' . $nameFile))) {
                        unlink(public_path('files/' . $nameFile));
                    }
                }
                $dataTeam = Team::select('id', 'name')->get()->toArray();
                $dataRoles = Role::select('id', 'name')->get()->toArray();
                $dataEmployeeTypes = EmployeeType::select('id', 'name')->get()->toArray();
                return view('employee.list_import', ['dataEmployees' => $dataEmployees, 'num' => $num, 'row' => $row, 'urlFile' => public_path('files/' . $nameFile), 'listError' => $listError, 'colError' => $colError, 'dataTeam' => $dataTeam, 'dataRoles' => $dataRoles, 'dataEmployeeTypes' => $dataEmployeeTypes]);
            } else {
                \Session::flash('msg_fail', trans('employee.valid_not_csv'));
                return redirect('employee');
            }

        } else {
            \Session::flash('msg_fail', trans('employee.valid_required_file'));
            return redirect('employee');
        }
    }

    public function importEmployee()
    {
        $urlFile = $_GET['urlFile'];
        $importFile = new ImportFile;

        $data = $importFile->readFile($urlFile);
        $num = $importFile->countCol($urlFile);
        $row = count($data) / $num;

        for ($row = 1; $row < count($data) / $num; $row++) {
            $c = $row * $num;
            if ($c < $row * ($num + 1)) {
                $employee = new Employee;
                $employee->email = $data[$c];
                $c++;
                $employee->password = ("123456");
                $employee->name = $data[$c];
                $c++;
                if($data[$c] == "-"){
                    $employee->birthday = null;
                }else{
                    $employee->birthday = date_create($data[$c]);
                }
                $c++;
                
                if (strnatcasecmp($data[$c], "female") == 0) {
                    $employee->gender = 1;
                } else if (strnatcasecmp($data[$c], "male") == 0) {
                    $employee->gender = 2;
                } else {
                    $employee->gender = 3;
                }
                $c++;
                if($data[$c] == "-"){
                    $employee->mobile = "";
                }else{
                    $employee->mobile = $data[$c];
                }
                $c++;
                if($data[$c] == "-"){
                    $employee->address = "";
                }else{
                    $employee->address = $data[$c];
                }
                $c++;
                if($data[$c] == "-"){
                    $employee->marital_status = 1;
                }else{
                    if (strnatcasecmp($data[$c], trans('employee.profile_info.marital_status.single')) == 0) {
                        $employee->marital_status = 1;
                    } else if (strnatcasecmp($data[$c], trans('employee.profile_info.marital_status.married')) == 0) {
                        $employee->marital_status = 2;
                    } else if (strnatcasecmp($data[$c], trans('employee.profile_info.marital_status.separated')) == 0) {
                        $employee->marital_status = 3;
                    } else {
                        $employee->marital_status = 4;
                    }
                }
                $c++;
                if($data[$c] == "-"){
                    $employee->startwork_date = null;
                }else{
                    $employee->startwork_date = date_create($data[$c]);
                }
                $c++;
                if($data[$c] == "-"){
                    $employee->endwork_date = null;
                    $employee->work_status = 0;
                }else{
                    $date = new DateTime;
                    $date = $date->format('Y-m-d H:i:s');
                    $employee->endwork_date = date_create($data[$c]);
                    if(strtotime($data[$c]) < strtotime($date)){
                        $employee->work_status = 1;
                    }else{
                        $employee->work_status = 0;
                    }
                }
                $c++;
                $employee->is_employee = 1;
                $objEmployeeType = EmployeeType::select('name', 'id')->where('name', 'like', $data[$c])->first();
                $employee->employee_type_id = $objEmployeeType->id;
                $c++;
                $objTeam = Team::select('name', 'id')->where('name', 'like', $data[$c])->first();



//                $employee->team_id = $objTeam->id;
                $c++;
                $objRole = Role::select('name', 'id')->where('name', 'like', $data[$c])->first();
                $employee->role_id = $objRole->id;
                $c++;
                $employee->created_at = new DateTime();
                $employee->delete_flag = 0;
                $employee->save();
                $employeeteam = new EmployeeTeam;
                $employeeteam->team_id=$objTeam->id;
                $employeeteam->employee_id=$employee->id;
                $employeeteam->save();
                $employee_permission = PermissionRole::where('role_id', $employee->role_id)->get();
                foreach ($employee_permission as $permission){
                    $PermissionEmployee = new PermissionEmployee;
                    $PermissionEmployee->permission_id = $permission->permission_id;
                    $PermissionEmployee->employee_id = $employee->id;
                    $PermissionEmployee->save();
                }
            }
        }
        if (file_exists($urlFile)) {
            unlink($urlFile);
        }
        \Session::flash('msg_success', trans('employee.msg_import.success'));
        return redirect('employee');
    }

    public function export(Request $request)
    {
        $time =(new \DateTime())->format('Y-m-d H:i:s');
        return Excel::download(new InvoicesExport($this->searchEmployeeService, $request), 'employee-list-'.$time.'.csv');
    }

    public function downloadTemplate()
    {
        $time =(new \DateTime())->format('Y-m-d H:i:s');
        return Excel::download(new TemplateExport(), 'employee-template-'.$time.'.csv');
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