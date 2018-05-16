<?php

namespace App\Http\Controllers\User\Vendor;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Http\Controllers\Controller;
use App\Service\SearchEmployeeService;
use App\Models\Employee;
use App\Import\ImportFile;
use App\Models\EmployeeType;
use DateTime;
class VendorController extends Controller
{
    private $searchEmployeeService;

    public function __construct(SearchEmployeeService $searchEmployeeService)
    {
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
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


                /*
                dem so cot -> kiem tra
                $templateExport = new TemplateExport;
                $colTemplateExport = $templateExport -> headings();
                count($colTemplateExport) truyen tam so
                */

                $colError = $importFile->checkCol(public_path('files/' . $nameFile), 13);
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
                $vendor->birthday = date_create($data[$c]);
                $c++;
                if (strnatcasecmp($data[$c], "female") == 0) {
                    $vendor->gender = 1;
                } else if (strnatcasecmp($data[$c], "male") == 0) {
                    $vendor->gender = 2;
                } else {
                    $vendor->gender = 3;
                }
                $c++;
                $vendor->mobile = $data[$c];
                $c++;
                $vendor->address = $data[$c];
                $c++;

                if (strnatcasecmp($data[$c], "single") == 0) {
                    $vendor->marital_status = 1;
                } else if (strnatcasecmp($data[$c], "married") == 0) {
                    $vendor->marital_status = 2;
                } else if (strnatcasecmp($data[$c], "separated") == 0) {
                    $vendor->marital_status = 3;
                } else {
                    $vendor->marital_status = 4;
                }
                $c++;
                $vendor->startwork_date = date_create($data[$c]);
                $c++;
                $vendor->endwork_date = date_create($data[$c]);
                $c++;
                $vendor->is_employee = 0;

                $objEmployeeType = EmployeeType::select('name', 'id')->where('name', 'like', $data[$c])->first();
                $vendor->employee_type_id = $objEmployeeType->id;
                $c++;

                $objRole = Role::select('name', 'id')->where('name', 'like', $data[$c])->first();
                $vendor->role_id = $objRole->id;
                $c++;
                $vendor->company = $data[$c];
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
}
