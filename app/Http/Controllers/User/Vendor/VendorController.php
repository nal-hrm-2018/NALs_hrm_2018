<?php

namespace App\Http\Controllers\User\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchRequest;
use App\Models\Employee;
use App\Models\Role;
use App\Models\Status;
use App\Service\ChartService;
use App\Service\SearchEmployeeService;
use App\Service\SearchService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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

    public function showChart($id, Request $request)
    {
        $year = $request->year;
        $vendor = Employee::find($id);
        $listValue = $this->chartService->getListValueOfMonth($vendor, $year);
        return response(['listValue' => $listValue]);
    }
}
