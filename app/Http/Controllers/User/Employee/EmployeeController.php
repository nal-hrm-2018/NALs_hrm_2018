<?php
/**
 * Created by PhpStorm.
 * User: Ngoc Quy
 * Date: 4/16/2018
 * Time: 11:26 AM
 */

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
use DateTime;
use App\Service\SearchService;
use App\Http\Requests\SearchRequest;
use Illuminate\Support\Facades\Input;
use App\Models\Status;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\EmployeeEditRequest;
class EmployeeController extends Controller
{
    /**
     * @var SearchEmployeeServiceProvider
     */
    private $searchEmployeeService;
    protected $searchService;
    private $chartService;

    public function __construct(SearchService $searchService, SearchEmployeeService $searchEmployeeService, ChartService $chartService)
    {
        $this->searchService = $searchService;
        $this->searchEmployeeService = $searchEmployeeService;
        $this->chartService = $chartService;
    }

    public function index(Request $request)
    {

        $roles = Role::pluck('name','id');
        $teams = Team::pluck('name','id');
        $employees = $this->searchEmployeeService->searchEmployee($request)->orderBy('id','asc')->get();
        return view('employee.list', compact('employees','roles','teams','param'));
    }

    public function create()
    {
        $dataTeam = Team::select('id', 'name')->get()->toArray();
        $dataRoles = Role::select('id', 'name')->get()->toArray();
        $dataEmployeeTypes = EmployeeType::select('id', 'name')->get()->toArray();
        return view('admin.module.employees.add', ['dataTeam' => $dataTeam, 'dataRoles' => $dataRoles, 'dataEmployeeTypes' => $dataEmployeeTypes]);
    }

    public function store(EmployeeAddRequest $request)
    {
        $objEmployee = Employee::select('email')->where('email', 'like', $request->email)->get()->toArray();
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


    /**
     * @param $id
     * @param SearchRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function show($id, SearchRequest $request)
    {
        $data = $request->only([
                'project_name' => $request->get('project_name'),
                'role' => $request->get('role'),
                'start_date' => $request->get('start_date'),
                'end_date' => $request->get('end_date'),
                'project_status' => $request->get('project_status'),
                'number_record_per_page' => $request->get('number_record_per_page')
            ]
        );

        if(!isset($data['number_record_per_page'])){
            $data['number_record_per_page']= config('settings.paginate');
        }

        $data['id']=$id;

        $processes = $this->searchService->search($data)->orderBy('project_id','desc')->paginate($data['number_record_per_page']);

        $processes->setPath('');

        $param = (Input::except('page'));

        $active = $request->all();

        if($active){
            $active='project';
        }else{
            $active='basic';
        }

        //set employee info
        $employee = Employee::find($id);

        $roles = Role::pluck('name', 'id')->prepend(trans('employee_detail.drop_box.placeholder-default'));;

        $project_statuses = Status::pluck('name','id')->prepend(trans('employee_detail.drop_box.placeholder-default'));

        if (!isset($employee)) {
            return abort(404);
        }


        //set chart
        $year = date('Y');
        $listValue = $this->chartService->getListValueOfMonth($employee, $year);

        //set list years
        $listYears = $this->chartService->getListYear($employee);

        return view('employee.detail', compact('employee', 'processes' , 'listValue', 'listYears', 'roles', 'param','project_statuses','active'))->render();
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
        if ($request->ajax()) {
            $employees = Employee::where('id', $id)->where('delete_flag', 0)->first();
            $employees->delete_flag = 1;
            $employees->save();

            return response(['msg' => 'Product deleted', 'status' => 'success', 'id' => $id]);
        }
        return response(['msg' => 'Failed deleting the product', 'status' => 'failed']);
    }



    public function showChart($id, Request $request){
        $year = $request->year;
        $employee = Employee::find($id);
        $listValue = $this->chartService->getListValueOfMonth($employee, $year);
        return response(['listValue' => $listValue]);
    }



    public function postFile(Request $request){
        $listError = "";
        if($request->hasFile('myFile')){
            $file = $request->file("myFile");
            if($file->getClientOriginalExtension('myFile') == "csv"){
                $nameFile = $file -> getClientOriginalName('myFile');
                $file ->move('files', $nameFile);
                $i = 0; $row = 0;
                $dataEmployees = array();
                $handle = fopen(public_path('files/'.$nameFile), "r");
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $num = count($data);
                    for ($c=0; $c < $num; $c++) {
                        $dataEmployees[$i] = $data[$c];
                        $i++;
                    }
                    $row++;
                }
                fclose($handle);
                $listError = "";
                $dataEmail = array();
                $dem = 0;
                for($i = 1; $i < $row; $i++){
                    if($listEmail == null){
                        for($j = i+1; $j <= $row; $j++){
                            if($dataEmployees[$i*16] == $dataEmployees[$j*16]){
                                $listError .= "<li>Email ".$dataEmployees[$i*16]." đã bị trùng.</li>";
                                $listEmail[$dem] = $dataEmployees[$i*16];
                                $dem++;
                            }
                        }
                    }else{
                        $check = 0;
                        for ($k=0; $k < $dem; $k++) { 
                            if($listEmail[$dem] == $dataEmployees[$i*16]){
                                $check = 1;
                            }
                        }
                        if($check == 0){
                            for($j = i+1; $j <= $row; $j++){
                                if($dataEmployees[$i*16] == $dataEmployees[$j*16]){
                                    $listError .= "<li>Email ".$dataEmployees[$i*16]." đã bị trùng.</li>";
                                    $listEmail[$dem] = $dataEmployees[$i*16];
                                    $dem++;
                                }
                            }
                        }
                    }
                }

                $row = 0;
                $handle = fopen(public_path('files/'.$nameFile), "r");
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $num = count($data);
                    $row++;
                    if($row > 1){
                        $c=0;
                        $employee = new Employee;
                        $objEmployee = Employee::select('email')->where('email', 'like', $data[$c])->get()->toArray();
                        if($objEmployee != null){
                            $listError .= "<li>STT: ".($row-1)." Email đã tồn tại.</li>";
                        }
                        $c++;
                        if(strlen($data[$c]) < 6){
                            $listError .= "<li>STT: ".($row-1)." Password không đúng. Password ít nhất 6 ký tự.</li>";
                        }
                        $c++;
                        if($data[$c] == null){
                            $listError .= "<li>STT: ".($row-1)." Name không đúng. Name không được để trống.</li>";   
                        }
                        $c++;
                        if($data[$c] == null){
                            $listError .= "<li>STT: ".($row-1)." Birthday không đúng. Birthday không được để trống.</li>"; 
                        }else{
                            if(date_create($data[$c]) == FALSE ){
                                $listError .= "<li>STT: ".($row-1)." Birthday không đúng định dạng. VD: 22-02-2000.</li>";
                            }
                        }
                        $c++;
                        if($data[$c] == null){
                            $listError .= "<li>STT: ".($row-1)." Gender không đúng. Gender không được để trống.</li>";   
                        }else{
                            if((int)$data[$c] < 1 || (int)$data[$c] >3){
                                $listError .= "<li>STT: ".($row-1)." Gender không đúng. Gender chỉ nhận được các giá trị 1, 2 hoặc 3.</li>";
                            }
                        }
                        $c++;
                        if($data[$c] == null){
                            $listError .= "<li>STT: ".($row-1)." Mobile không đúng. Mobile không được để trống.</li>";  
                        }else{
                            $stMb = $data[$c];
                            for($k=0; $k < strlen($data[$c]); $k++){
                                if( $stMb[$k] < "0" || $stMb[$k] > "9" ){
                                    $listError .= "<li>STT: ".($row-1)." Mobile chỉ được nhập số.</li>";
                                    break;
                                }
                            }
                        }
                        $c++;
                        if($data[$c] == null){
                            $listError .= "<li>STT: ".($row-1)." address không đúng. address không được để trống.</li>"; 
                        }
                        $c++;
                        if($data[$c] == null){
                            $listError .= "<li>STT: ".($row-1)." marital_status không đúng. marital_status không được để trống.</li>";
                        }else{
                            if((int)$data[$c] < 1 || (int)$data[$c] >4){
                                $listError .= "<li>STT: ".($row-1)." marital_status không đúng. marital_status chỉ nhận được các giá trị 1, 2, 3 hoặc 4.</li>";
                            }
                        }
                        $c++;
                        if($data[$c] == null){
                            $listError .= "<li>STT: ".($row-1)." startwork_date không đúng. startwork_date không được để trống.</li>";   
                        }else{
                            if(date_create($data[$c]) == FALSE ){
                                $listError .= "<li>STT: ".($row-1)." startwork_date không đúng định dạng. VD: 22-02-2000.</li>";
                            }
                        }
                        $c++;
                        if($data[$c] == null){
                            $listError .= "<li>STT: ".($row-1)." endwork_date không đúng. endwork_date không được để trống.</li>";  
                        }else{
                            if(date_create($data[$c]) == FALSE ){
                                $listError .= "<li>STT: ".($row-1)." endwork_date không đúng định dạng. VD: 22-02-2000.</li>";
                            }else{
                                if(date_create($data[$c - 1]) != FALSE){
                                    if(strtotime($data[$c - 1]) > strtotime($data[$c])){
                                        $listError .= "<li>STT: ".($row-1)." endwork_date không đúng định dạng. VD: 22-02-2000.</li>";
                                    }
                                }
                            }

                        }
                        $c++;
                        if($data[$c] == null){
                            $listError .= "<li>STT: ".($row-1)." is_employee không đúng. is_employee không được để trống.</li>";
                        }else{
                            if((int)$data[$c] < 1){
                                $listError .= "<li>STT: ".($row-1)." is_employee không đúng. is_employee chỉ nhận giá trị số lớn hơn 0.</li>";
                            }
                        }
                        $c++;
                        if($data[$c] == null){
                            $listError .= "<li>STT: ".($row-1)." company không đúng. company không được để trống.</li>"; 
                        }
                        $c++;
                        if($data[$c] == null){
                            $listError .= "<li>STT: ".($row-1)." employee_type_id không đúng. employee_type_id không được để trống.</li>";  
                        }else{
                            if((int)$data[$c] < 1){
                                $listError .= "<li>STT: ".($row-1)." employee_type_id không đúng. employee_type_id chỉ nhận giá trị số lớn hơn 0.</li>";
                            }
                        }
                        $c++;
                        if($data[$c] == null){
                            $listError .= "<li>STT: ".($row-1)." team_id không đúng. team_id không được để trống.</li>";
                        }else{
                            if((int)$data[$c] < 1){
                                $listError .= "<li>STT: ".($row-1)." team_id không đúng. team_id chỉ nhận giá trị số lớn hơn 0.</li>";
                            }
                        }
                        $c++;
                        if($data[$c] == null){
                            $listError .= "<li>STT: ".($row-1)." role_id không đúng. role_id không được để trống.</li>";
                        }else{
                            if((int)$data[$c] < 1){
                                $listError .= "<li>STT: ".($row-1)." role_id không đúng. role_id chỉ nhận giá trị số lớn hơn 0.</li>";
                            }
                        }
                        $c++;
                        if($data[$c] == null){
                            $listError .= "<li>STT: ".($row-1)." delete_flag không đúng. delete_flag không được để trống.</li>";
                        }else{
                            if($data[$c] != "1" && $data[$c] != "0"){
                                $listError .= "<li>STT: ".($row-1)." delete_flag không đúng. delete_flag chỉ nhận giá trị số 0 hoặc 1.</li>";
                            }
                        }      
                    }
                }
                fclose($handle);
                if($listError != null){
                    if(file_exists(public_path('files/'.$nameFile))){
                        unlink(public_path('files/'.$nameFile));
                    }
                }
                return view('admin.module.employees.list_import', ['dataEmployees' => $dataEmployees, 'num' => $num, 'row' => $row , 'urlFile' => public_path('files/'.$nameFile), 'listError' => $listError]);
            }else{
                \Session::flash('msg_fail', 'The file is not formatted correctly!!!');
                return redirect('employee');
            }
        }else{
            \Session::flash('msg_fail', 'File not selected!!!');
            return redirect('employee');
        }
    }
    public function importEmployee(){
        $urlFile = $_GET['urlFile'];
        $row = 1;
        $handle = fopen($urlFile, "r");
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $num = count($data);
            $row++;
            if($row > 2){
                $c=0;
                $employee = new Employee;
                $objEmployee = Employee::select('email')->where('email', 'like', $data[$c])->get()->toArray();
                $employee -> email = $data[$c]; $c++;          
                $employee -> password = bcrypt($data[$c]); $c++;
                $employee -> name = $data[$c]; $c++;
                $employee -> birthday = date_create($data[$c]); $c++;
                $employee -> gender = $data[$c]; $c++;
                $employee -> mobile = $data[$c]; $c++;
                $employee -> address = $data[$c]; $c++;
                $employee -> marital_status = $data[$c]; $c++;
                $employee -> startwork_date = date_create($data[$c]); $c++;
                $employee -> endwork_date = date_create($data[$c]); $c++;
                $employee -> is_employee = $data[$c]; $c++;
                $employee -> company = $data[$c]; $c++;
                $employee -> employee_type_id = $data[$c]; $c++;
                $employee -> team_id = $data[$c]; $c++;
                $employee -> role_id = $data[$c]; $c++;
                $employee -> created_at = new DateTime();
                $employee -> delete_flag = (int)$data[$c]; $c++;
                $employee ->save();
            }
        }
        fclose($handle);
        if(file_exists($urlFile)){
            unlink($urlFile);
        }
        \Session::flash('msg_success', 'Import Employees successfully!!!');
        return redirect('employee');        
    }

    public function  export(Request $request){
        return Excel::download(new InvoicesExport($this->searchEmployeeService, $request), 'employee-list.csv');
    }
    public function  downloadTemplate(){
        return Excel::download(new TemplateExport(),'template.csv');
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