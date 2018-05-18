<?php

namespace App\Http\Controllers\User\Vendor;


use App\Export\TemplateVendorExport;
use App\Export\VendorExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\VendorEditRequest;
use App\Service\SearchService;
use App\Http\Requests\VendorAddRequest;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Models\Employee;
use App\Models\Role;
use App\Models\Status;
use App\Service\ChartService;
use App\Models\EmployeeType;
use DateTime;
use App\Service\SearchEmployeeService;
use App\Import\ImportFile;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;
class VendorController extends Controller
{
    protected $searchService;
    private $chartService;
    private $searchEmployeeService;
    public function __construct(SearchService $searchService, ChartService $chartService, SearchEmployeeService $searchEmployeeService)
    {
        $this->searchService = $searchService;
        $this->chartService = $chartService;
        $this->searchEmployeeService = $searchEmployeeService;
    }

    public function index(Request $request)
    {
        $status = [0 => "Active", 1 => "Unactive"];
        $roles = Role::where('delete_flag', 0)->orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        $request['is_employee'] = config('settings.Employees.not_employee');
        $vendors = $this->searchEmployeeService->searchEmployee($request)->orderBy('id', 'asc')->get();
        return view('vendors.list', compact('vendors', 'roles', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $genders = [1 => config('settings.Gender.female'), 2 => config('settings.Gender.male'),
            3=>config('settings.Gender.n_a')];

        $marries = [1=>config('settings.Married.single'),2=>config('settings.Married.married'),
            3=>config('settings.Married.separated'),4=>config('settings.Married.devorce')];

        $roles = Role::where('delete_flag', 0)->orderBy('name', 'asc')->pluck('name', 'id')->toArray();

        $employeeTypes = EmployeeType::where('delete_flag', 0)->orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        return view('vendors.add', compact('teams','roles','employeeTypes','genders','marries'));
    }


    public function store(VendorAddRequest $request)
    {
        $data =[
            'email'=>$request->get('email'),
            'password'=>bcrypt($request->get('password')),
            'name'=>$request->get('name'),
            'address'=>$request->get('address'),
            'mobile'=>$request->get('mobile'),
            'gender'=>$request->get('gender'),
            'marital_status'=>$request->get('marital_status'),
            'birthday'=>$request->get('birthday'),
            'company'=>$request->get('company'),
            'employee_type_id'=>$request->get('employee_type_id'),
            'role_id'=>$request->get('role_id'),
            'startwork_date'=>$request->get('startwork_date'),
            'endwork_date'=>$request->get('endwork_date'),
            'is_employee'=>config('settings.Employees.not_employee'),
            'delete_flag'=>config('settings.delete_flag.not_deleted'),
            'work_status'=>config('settings.work_status.active'),
        ];

        if(is_null(Employee::create($data))){
            session()->flash(trans('vendor.msg_fails'), trans('vendor.msg_content.msg_add_fail'));
            return back()->withInput(Input::all());
        }else{
            session()->flash(trans('vendor.msg_success'), trans('vendor.msg_content.msg_add_success'));
            return redirect(route('vendors.index'));
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
                'number_record_per_page' => $request->get('number_record_per_page')
            ]
        );

        if (!isset($data['number_record_per_page'])) {
            $data['number_record_per_page'] = config('settings.paginate');
        }

        $data['id'] = $id;

        $processes = $this->searchService->searchProcess($data)->orderBy('project_id', 'desc')->paginate($data['number_record_per_page']);

        $processes->setPath('');

        $param = (Input::except('page'));

        if ($request->get('number_record_per_page')) {
            $active = 'project';
        } else {
            $active = 'basic';
        }

        //set employee info
        $vendor = Employee::where('delete_flag', 0)->where('is_employee', '0')->find($id);

        $roles = Role::orderBy('name', 'asc')->pluck('name', 'id')->toArray();

        $project_statuses = Status::orderBy('name', 'asc')->pluck('name', 'id')->toArray();

        if (!isset($vendor)) {
            return abort(404);
        }

        //set chart
        $year = date('Y');
        $listValue = $this->chartService->getListValueOfMonth($vendor, $year);

        //set list years
        $listYears = $this->chartService->getListYear($vendor);

        return view('vendors.detail', compact('vendor',
            'processes',
            'listValue',
            'listYears',
            'roles',
            'param',
            'project_statuses',
            'active'))
            ->render();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = Employee::where('delete_flag', 0)->where('is_employee',0)->find($id);
        if ($employee == null) {
            return abort(404);
        }
        $objEmployee = Employee::where('delete_flag', 0)->findOrFail($id)->toArray();
        $dataTeam = Team::select('id', 'name')->where('delete_flag', 0)->get()->toArray();
        $dataRoles = Role::select('id', 'name')->where('delete_flag', 0)->get()->toArray();
        $dataEmployeeTypes = EmployeeType::select('id', 'name')->get()->toArray();

        return view('vendors.edit', ['objEmployee' => $objEmployee, 'dataTeam' => $dataTeam, 'dataRoles' => $dataRoles, 'dataEmployeeTypes' => $dataEmployeeTypes]);
    }


    public function update(VendorEditRequest $request, $id)
    {
        $employee = Employee::where('delete_flag', 0)->where('is_employee',0)->find($id);
        if ($employee == null) {
            return abort(404);
        }
        $employee->email = $request->email;
        $employee->name = $request->name;
        $employee->birthday = $request->birthday;
        $employee->gender = $request->gender;
        $employee->mobile = $request->mobile;
        $employee->address = $request->address;
        $employee->marital_status = $request->marital_status;
        $employee->company = $request->company;
        $employee->startwork_date = $request->startwork_date;
        $employee->endwork_date = $request->endwork_date;
        $employee->employee_type_id = $request->employee_type_id;
        $employee->role_id = $request->role_id;
        $employee->updated_at = new DateTime();
        if ($employee->save()) {
            \Session::flash('msg_success', 'Account successfully edited!!!');
            return redirect('vendors');            
        } else {
            \Session::flash('msg_fail', 'Edit failed!!!');
            return back()->with(['vendors' => $employee]);
        }
    }

     public function editPass(Request $request)
    {
        $employee = Employee::find(\Illuminate\Support\Facades\Auth::user()->id);
        $oldPass = $request -> old_pass;
        $newPass = $request -> new_pass;
        $cfPass = $request -> cf_pass;
        if(!Hash::check($oldPass, $employee -> password)){
            return back()->with(['error' => 'Old password is incorrect!!!', 'employee' => $employee]);
        }else{
            if($newPass != $cfPass){
                return back()->with(['error' => 'The confirm password and password must match!!!', 'employee' => $employee]);
            }else{
                if (strlen($newPass) < 6) {
                    return back()->with(['error' => 'The Password must be at least 6 characters!!!', 'employee' => $employee]);
                }else {
                    $employee->password = bcrypt($newPass);
                    $employee->save();
                    \Session::flash('msg_success', 'Password successfully edited!!!');
                    return redirect('vendors/'.$employee->id.'/edit');
                }
            }
        }
    }
    public function destroy($id, Request $request)
    {
        $employees = Employee::where('id', $id)->where('delete_flag', 0)->first();
        if ($request->ajax()) {
            if (is_null($employees)) {
                return response(['msg' => 'Failed deleting the Vendor', 'status' => 'failed']);
            } else {
                $employees->delete_flag = 1;
                $employees->save();
                return response(['msg' => 'Vendor deleted', 'status' => 'success', 'id' => $id]);
            }
        } else {
            if (is_null($employees)) {
                return abort(404);
            } else {
                $employees->delete_flag = 1;
                $employees->save();
                return redirect(route('vendors.index'));
            }
        }
    }
    public function postFile(Request $request)
    {
        $listError = "";
        if ($request->hasFile('myFile')) {
            $file = $request->file("myFile");
            if ($file->getClientOriginalExtension('myFile') == "csv") {
                $nameFile = $file->getClientOriginalName('myFile');
                $file->move('files', $nameFile);

                $importFile = new ImportFile;

                $dataVendor = $importFile->readFile(public_path('files/' . $nameFile));
                $num = $importFile->countCol(public_path('files/' . $nameFile));

                $templateExport = new TemplateVendorExport;
                $colTemplateExport = $templateExport -> headings();

                $colError = $importFile->checkCol(public_path('files/' . $nameFile), count($colTemplateExport));
                if ($colError != null) {
                    if (file_exists(public_path('files/' . $nameFile))) {
                        unlink(public_path('files/' . $nameFile));
                    }
                    return view('vendors.list_import', ['urlFile' => public_path('files/' . $nameFile), 'colError' => $colError, 'listError' => $listError]);
                }
                $row = count($dataVendor) / $num;
                $listError .= $importFile->checkEmail($dataVendor, $row, $num);
                $listError .= $importFile->checkFileVendor($dataVendor, $num);

                if ($listError != null) {
                    if (file_exists(public_path('files/' . $nameFile))) {
                        unlink(public_path('files/' . $nameFile));
                    }
                }
                $dataRoles = Role::select('id', 'name')->get()->toArray();
                $dataEmployeeTypes = EmployeeType::select('id', 'name')->get()->toArray();
                return view('vendors.list_import', ['dataVendor' => $dataVendor, 'num' => $num, 'row' => $row, 'urlFile' => public_path('files/' . $nameFile), 'listError' => $listError, 'colError' => $colError, 'dataRoles' => $dataRoles, 'dataEmployeeTypes' => $dataEmployeeTypes]);
            } else {
                \Session::flash('msg_fail', 'The file is not formatted correctly!!!');
                return redirect('vendors');
            }
        } else {
            \Session::flash('msg_fail', 'File not selected!!!');
            return redirect('vendors');
        }
    }

    public function importVendor()
    {
        $urlFile = $_GET['urlFile'];
        $importFile = new ImportFile;

        $data = $importFile->readFile($urlFile);
        $num = $importFile->countCol($urlFile);
        $row = count($data) / $num;

        for ($row = 1; $row < count($data) / $num; $row++) {
            $c = $row * $num;
            if ($c < $row * ($num + 1)) {
                $vendor = new Employee;
                $vendor->email = $data[$c];
                $c++;
                $vendor->password = bcrypt($data[$c]);
                $c++;
                $vendor->name = $data[$c];
                $c++;
                if($data[$c] == "-"){
                    $vendor->birthday = date_create("0-0-0");
                }else{
                    $vendor->birthday = date_create($data[$c]);
                }
                $c++;
                if (strnatcasecmp($data[$c], "female") == 0) {
                    $vendor->gender = 1;
                } else if (strnatcasecmp($data[$c], "male") == 0) {
                    $vendor->gender = 2;
                } else {
                    $vendor->gender = 3;
                }
                $c++;
                if($data[$c] == "-"){
                    $vendor->mobile = "";
                }else{
                    $vendor->mobile = $data[$c];
                }
                $c++;
                if($data[$c] == "-"){
                    $vendor->address = "";
                }else{
                    $vendor->address = $data[$c];
                }
                $c++;
                if($data[$c] == "-"){
                    $vendor->address = 1;
                }else{
                    if (strnatcasecmp($data[$c], "single") == 0) {
                        $vendor->marital_status = 1;
                    } else if (strnatcasecmp($data[$c], "married") == 0) {
                        $vendor->marital_status = 2;
                    } else if (strnatcasecmp($data[$c], "separated") == 0) {
                        $vendor->marital_status = 3;
                    } else {
                        $vendor->marital_status = 4;
                    }
                }
                $c++;
                if($data[$c] == "-"){
                    $vendor->startwork_date = date_create("0-0-0");
                }else{
                    $vendor->startwork_date = date_create($data[$c]);
                }
                $c++;
                if($data[$c] == "-"){
                    $vendor->endwork_date = date_create("1-0-0");
                }else{
                    $vendor->endwork_date = date_create($data[$c]);
                }
                $c++;
                $vendor->is_employee = 0;

                $objEmployeeType = EmployeeType::select('name', 'id')->where('name', 'like', $data[$c])->first();
                $vendor->employee_type_id = $objEmployeeType->id;
                $c++;
                if($data[$c] == "-"){
                    $vendor->company = "";
                }else{
                    $vendor->company = $data[$c];
                }
                $c++;

                $objRole = Role::select('name', 'id')->where('name', 'like', $data[$c])->first();
                $vendor->role_id = $objRole->id;
                $c++;
                
                $vendor->created_at = new DateTime();
                $vendor->delete_flag = 0;
                $vendor->save();
            }
        }
        if (file_exists($urlFile)) {
            unlink($urlFile);
        }
        \Session::flash('msg_success', 'Import Vendors successfully!!!');
        return redirect('vendors');
    }

    public function export(Request $request)
    {
        return Excel::download(new VendorExport($this->searchEmployeeService, $request), 'vendor-list.csv');
    }
    public function downloadTemplateVendor()
    {
        return Excel::download(new TemplateVendorExport(), 'template-vendor.csv');
    }

    public function showChart($id, Request $request)
    {
        $year = $request->year;
        $vendor = Employee::find($id);
        $listValue = $this->chartService->getListValueOfMonth($vendor, $year);
        return response(['listValue' => $listValue]);
    }
}
