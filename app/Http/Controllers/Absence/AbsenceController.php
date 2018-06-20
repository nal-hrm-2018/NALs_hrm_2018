<?php

namespace App\Http\Controllers\Absence;

use App\Export\HRAbsenceExport;
use App\Http\Controllers\Controller;
use App\Service\AbsenceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\Service\SearchEmployeeService;
use App\Http\Rule\Absence\ValidAbsenceFilter;
use App\Models\Employee;
use App\Models\AbsenceStatus;
use App\Models\AbsenceType;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
class AbsenceController extends Controller
{
    protected $absenceService;
    private $searchEmployeeService;

    public function __construct(AbsenceService $absenceService, SearchEmployeeService $searchEmployeeService)
    {
        $this->searchEmployeeService = $searchEmployeeService;
        $this->absenceService = $absenceService;
    }

    public function indexHR(Request $request)
    {
        $validator = Validator::make(
            $request->input(),
            [
                'month_absence' => new ValidAbsenceFilter(
                    $request->get('year_absence')
                )
            ]
        );
        if ($validator->fails()) {
            view()->share('errors',$validator->errors());
        }
        if (!isset($request['number_record_per_page'])) {
            $request['number_record_per_page'] = config('settings.paginate');
        }
        $month_absences = getArrayMonth();
        $year_absences = $this->absenceService->getArrayYearAbsence();
        $employees = $this->searchEmployeeService->searchEmployee($request)->orderBy('id', 'asc')->paginate($request['number_record_per_page']);
        $employees->setPath('');
        $param = (Input::except(['page', 'is_employee']));
        session()->flashInput($request->input());
        return view('absences.hr_list', compact('employees', 'param', 'month_absences', 'year_absences'));
    }
    public function exportAbsenceHR(Request $request){
        $time =(new \DateTime())->format('Y-m-d H:i:s');
        return Excel::download(new HRAbsenceExport(null, $request), 'absence-list-'.$time.'.csv');
    }

    public function index(Request $request)
    {
        /*dd($abc->soNgayNghiPhep(1,2017,0));
        dd($abc->soNgayDuocNghiPhep(1,2017));*/
        return view('vangnghi.list');
    }

    public function create()
    {

    }

    public function store(Request $request)
    {

    }

    public function show($id, Request $request)
    {

    }

    public function edit($id)
    {

    }

    public function update(Request $request, $id)
    {

    }

    public function destroy($id, Request $request)
    {

    }

    // function create by Quy.
    public function showListAbsence()
    {
        $getIdUserLogged = Auth::id();
        $getTeamOfUserLogged = Employee::find($getIdUserLogged);
        $getAllAbsenceType = AbsenceType::all();
        $getAllAbsenceStatus = AbsenceStatus::all();
        $getAllEmployeeByTeamUserLogged = Employee::where('team_id', $getTeamOfUserLogged->team_id)
            ->where('delete_flag', 0)->where('is_employee', 1);
        $allAbsenceByUserLogged = array();
        $allEmployeeByUserLogged = array();
        $allAbsenceNotNull = array();
        $allEmployeeNotNull = array();
        foreach ($getAllEmployeeByTeamUserLogged->get() as $addEmployee) {
            array_push($allAbsenceByUserLogged, $addEmployee->absences);
            array_push($allEmployeeByUserLogged, $addEmployee);
        }
        foreach ($allAbsenceByUserLogged as $allEmployee) {
            foreach ($allEmployee as $element) {
                if (!is_null($element)) {
                    array_push($allAbsenceNotNull, $element);
                }
            }
        }
        foreach ($allEmployeeByUserLogged as $allEmployee) {
            foreach ($allEmployee->absences as $element) {
                if (!is_null($element)) {
                    array_push($allEmployeeNotNull, $allEmployee);
                }
            }

        }
        foreach ($allEmployeeNotNull as $element) {

        }
        return view('absences.poteam', compact('allEmployeeNotNull', 'allAbsenceNotNull', 'getIdUserLogged', 'getAllAbsenceType', 'getAllAbsenceStatus'));
    }
}
