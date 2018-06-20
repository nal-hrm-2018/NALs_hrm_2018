<?php

namespace App\Http\Controllers\Absence;

use App\Http\Controllers\Controller;
use App\Service\AbsenceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\Service\SearchEmployeeService;
use App\Http\Rule\Absence\ValidAbsenceFilter;
class AbsenceController extends Controller
{
    protected $absenceService;
    private $searchEmployeeService;
    public function __construct(AbsenceService $absenceService, SearchEmployeeService $searchEmployeeService)
    {
        $this->searchEmployeeService = $searchEmployeeService;
        $this->absenceService=$absenceService;
    }
    public function indexHR(Request $request){
        $validator = Validator::make(
            $request->input(),
            [
                'month_absence'=> new ValidAbsenceFilter(
                    $request->get('year_absence')
                )
            ]
        );
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }
        if (!isset($request['number_record_per_page'])) {
            $request['number_record_per_page'] = config('settings.paginate');
        }
        $month_absences = getArrayMonth();
        $year_absences =$this->absenceService->getArrayYearAbsence();
        $employees = $this->searchEmployeeService->searchEmployee($request)->orderBy('id', 'asc')->paginate($request['number_record_per_page']);
        $employees->setPath('');
        $param = (Input::except(['page','is_employee']));
        session()->flashInput($request->input());
        return view('absences.hr_list',compact('employees','param','month_absences','year_absences'));
    }
    public function show($id)
    {}
}
