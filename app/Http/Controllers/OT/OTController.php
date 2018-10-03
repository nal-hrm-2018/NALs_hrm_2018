<?php

namespace App\Http\Controllers\OT;

use App\Http\Controllers\Controller;
use App\Models\AbsenceType;
use App\Models\Employee;
use App\Models\Overtime;
use App\Models\Project;
use App\Models\Process;
use App\Models\Team;
use App\Models\Role;
use App\Models\OvertimeStatus;
use Illuminate\Http\Request;
use App\Models\DayType;
use App\Models\HolidayDefault;
use App\Models\Holiday;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\OvertimeAddRequest;
use App\Http\Requests\OvertimeRequest;
use App\Service\SearchEmployeeService;
use Illuminate\Support\Facades\Input;

class OTController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $objOT;
    protected $objProcess;
    protected $searchOvertimeService;
    public function __construct (Overtime $objOT,Process $objProcess, SearchEmployeeService $searchEmployeeService)
    {
        $this->objOT=$objOT;
        $this->objProcess = $objProcess;
        $this->searchEmployeeService = $searchEmployeeService;
    }

    public function indexPO(Request $request)
    {   
        $ot_status = OvertimeStatus::whereIn('name', ['Accepted', 'Rejected'])->get();
        $ot_type = DayType::all();
        $user_id=Auth::user()->id;
        $id_re = OvertimeStatus::where('name','Reviewing')->first()->id;
        $id_no = OvertimeStatus::where('name','Not yet')->first()->id;

        $processes = Process::where('employee_id', $user_id)->where('delete_flag', 0)->with(['role' => function($query) {
            $query->where('name', 'PO');
        }])->get()->toArray();
        
        $project_po = [];
        foreach($processes as $process){
            if($process['role'] != null){
                $project_po[] = $process['project_id'];
            }
        }
        // dd($project_po);

        $processes = Process::whereIn('project_id', $project_po)->where('delete_flag', 0)->with(['role' => function($query) {
            $query->where('name', 'Dev');
        }])->get()->toArray();

        

        $process_dev_id = [];
        foreach($processes as $process){
            if($process['role'] != null){
                $process_dev_id[] = $process['id'];
            }
        }
        $is_manager = Employee::where('id',$user_id)->get()->pluck('is_manager')->toArray()[0];     
        $request['is_manager'] = $is_manager;
        if($is_manager) {
            $processes = Process::where('delete_flag', 0)->with(['role' => function($query) {
                $query->where('name', 'PO');
            }])->get()->toArray();
            foreach($processes as $process){
                if($process['role'] != null){
                    $process_dev_id[] = $process['id'];
                }
            }
        }
        
        $request['process_dev_id'] = $process_dev_id;
        $oldmonth = date('d');
        $oldmonth = date("Y-m-d", strtotime('-'.$oldmonth.' day'));
        $request['oldmonth'] = $oldmonth;
        
        $ot_review = $this->searchEmployeeService->searchOvertimePO($request)->whereHas('status', function ($query) {
            $query->where('is_accept', 0);
        });
        $ot_review = $ot_review->get();

        // dd($ot_review->toArray());
        
        $ot = $this->searchEmployeeService->searchOvertimePO($request)->whereHas('status', function ($query) {
            $query->where('is_accept', 1);
        });;
        
        if (!isset($request['number_record_per_page'])) {
            $request['number_record_per_page'] = config('settings.paginate');
        }
        $ot = $ot->paginate($request['number_record_per_page']);
        $ot->setPath('');

        foreach($ot_review as $value){
            if($value['status']['name'] == 'Not yet' ){
                $overtime = Overtime::where('id', $value['id'])->first();
                $overtime->overtime_status_id = $id_re;
                $overtime->save();
            }
        }
        return view('overtime.po_list',[
            'ot' => $ot,
            'ot_review' => $ot_review,
            'ot_status' => $ot_status,
            'ot_type' => $ot_type,
            ]);
    }

    public function acceptOT($id){
        $overtime = Overtime::find($id);
        $status_ot = OvertimeStatus::where('name','Accepted')->first();
        $overtime->overtime_status_id = $status_ot->id;
        $overtime->correct_total_time = $overtime->total_time;
        $overtime->save();
        $id=Auth::user()->id;
        return redirect()->route('po-ot');
    }

    public function rejectOT(OvertimeRequest $request,$id){
        $id_emp = Auth::user()->id;
        $correct_total_time = $request->correct_total_time;
        $overtime = Overtime::where('id',$id)->first();
        $overtime->reason_reject = $request->reason_reject;
        $total_time = $overtime->total_time;
        
        if($total_time<$correct_total_time){
            \Session::flash('msg_fail', trans('overtime.reject.fail'));
            return redirect()->route('po-ot');
        }else{
            $overtime->overtime_status_id = OvertimeStatus::where('name','Rejected')->first()->id;
            $overtime->correct_total_time = $correct_total_time;
        }
        $overtime->save();
        return redirect()->route('po-ot');
    }
    public function indexHR(Request $request)
    {
        $employees = $this->searchEmployeeService->searchEmployee($request)->orderBy('id', 'asc')->with('overtime.status', 'overtime.type');

        $projects = Project::select('id', 'name')->where('delete_flag', 0)->get();
        if (!isset($request['number_record_per_page'])) {
            $request['number_record_per_page'] = config('settings.paginate');
        }
        $employees = $employees->paginate($request['number_record_per_page']);
        $from_date = date("Y-m-01");
        $to_date = date("Y-m-t");
        if($request['from_date'] || $request['to_date']){
            $from_date = $request['from_date'];
            $to_date = $request['to_date'];
        }
        foreach($employees as $employee){
            $normal = null;
            $weekend = null;
            $holiday = null;
            count($employee->overtime);
            if(count($employee->overtime)){
                foreach($employee->overtime as $ot){
                    if($ot->date->format('Y-m-d') >= $from_date && $ot->date->format('Y-m-d') <= $to_date){
                        if($ot->status->is_accept == 1){
                            if($ot->type->name == 'normal'){
                                $normal += $ot->correct_total_time;
                            }
                            if($ot->type->name == 'weekend'){
                                $weekend += $ot->correct_total_time;
                            }
                            if($ot->type->name == 'holiday'){
                                $holiday += $ot->correct_total_time;
                            }
                        }
                    }
                }
            }
            unset($employee->overtime);
            $employee->overtime->normal = $normal;
            $employee->overtime->weekend = $weekend;
            $employee->overtime->holiday = $holiday;
        }
        // print_r($employees->toArray());

        $param = (Input::except(['page','is_employee']));
        return view('overtime.hr_list',compact('employees','param','projects'));
    }

    public function index(Request $request)
    {
        $id=Auth::user()->id;
        $oldmonth = date('d');
        $oldmonth = date("Y-m-d", strtotime('-'.$oldmonth.' day'));
        $request['oldmonth'] = $oldmonth;
        $ot_status = OvertimeStatus::all();
        $ot_type = Daytype::all();
        $request['user_id'] = $id;
        
        $overtime = $this->searchEmployeeService->searchOvertime($request);
        if (!isset($request['number_record_per_page'])) {
            $request['number_record_per_page'] = config('settings.paginate');
        }
        $overtime = $overtime->paginate($request['number_record_per_page']);
        $overtime->setPath('');
        
        $normal = null;
        $weekend = null;
        $holiday = null;
        foreach($overtime as $val){
            if($val->status->name == 'Accepted' || $val->status->name == 'Rejected'){
                if($val->type->name == 'normal'){
                    $normal += $val->correct_total_time;
                }elseif($val->type->name == 'weekend'){
                    $weekend += $val->correct_total_time;
                }elseif($val->type->name == 'holiday'){
                    $holiday += $val->correct_total_time;
                }
            }
        }
        $param = (Input::except(['page','is_employee']));
        $time = ['normal' => $normal,'weekend' => $weekend,'holiday' => $holiday];
        return view('overtime.list', [
            'ot' => $overtime,
            'time' => $time,
            'ot_status' => $ot_status,
            'ot_type' => $ot_type,
            'param' => $param,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $id=Auth::user()->id;
        $processes = Process::where('employee_id',$id)->where('check_project_exit', 0)->with('project')->get();
        return view('overtime.add',compact('processes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OvertimeAddRequest $request)
    {
        $id=Auth::user()->id;
        $overtime = new Overtime();
        $overtime->employee_id = $id;
        $project = $this->objProcess->countProcess();
        if($project > 0){
            $overtime->process_id = $request->process_id;
        }else{
            $overtime->process_id = null;
        }

        $dayType = DayType::all()->toArray();
        $typeId = [];
        //Get day type id 
        foreach($dayType  as $val){
            $typeId[$val['name']] = $val['id'];
        }
        $sttHoliday = 1;
        if(date('N', strtotime($request->date)) >= 6){
            $sttHoliday = 2;
        }

        //kiểm tra co phải ngày nghĩ lễ không.
        $holiday = HolidayDefault::all();
        foreach ($holiday as $holiday){
            $holidayDefault = date_format($holiday->date,"m-d");
            $holidayRequest = date('m-d', strtotime($request->date));
            if($holidayDefault == $holidayRequest){
                $sttHoliday = $typeId['holiday'];
                break;
            }
        }
        //Kiểm tra co phải ngày nghĩ đột xuất k
        if ($sttHoliday  == 1){
            $holidays = Holiday::with('type')->get();
            foreach ($holidays as $holiday){
                $holiday->type->name;
                $holidayAdded = $holiday->date->format('Y-m-d');
                $holidayRequest = date('Y-m-d', strtotime($request->date));
                if($holidayAdded == $holidayRequest){
                    $sttHoliday = $typeId[$holiday->type->name];
                }
            }
        }
        
        $overtime->date = $request->date;
        $overtime->day_type_id = $sttHoliday;
        $overtime->start_time = $request->start_time;
        $overtime->end_time = $request->end_time;
        $overtime->total_time = $request->total_time;
        $overtime->reason = $request->reason;

        if($overtime->save()){
            \Session::flash('msg_success', trans('overtime.msg_add.success'));
            return redirect('ot');
        }else{
            \Session::flash('msg_fail', trans('overtime.msg_add.fail'));
            return back()->with(['overtime' => $overtime]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user_id=Auth::user()->id;
        $ot_history = Overtime::where('delete_flag', 0)->with('process.project')->find($id);
        $processes = Process::where('employee_id',$user_id)->where('check_project_exit', 0)->with('project')->get();
        $overtime_type = Daytype::all();
        if ($ot_history == null) {
            return abort(404);
        }
        return view('overtime.edit',[
            'ot_history'=> $ot_history,
            'processes' => $processes,
            'overtime_type'=> $overtime_type,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(OvertimeAddRequest $request, $id)
    {
        // dd("testing"); die();
        $overtime = Overtime::where('delete_flag',0)->find($id);
        if ($overtime == null) {
            return abort(404);
        }
        

        $dayType = DayType::all()->toArray();
        $typeId = [];
        //Get day type id 
        foreach($dayType  as $val){
            $typeId[$val['name']] = $val['id'];
        }
        $sttHoliday = 1;
        if(date('N', strtotime($request->date)) >= 6){
            $sttHoliday = 2;
        }

        //kiểm tra co phải ngày nghĩ lễ không.
        $holiday = HolidayDefault::all();
        foreach ($holiday as $holiday){
            $holidayDefault = date_format($holiday->date,"m-d");
            $holidayRequest = date('m-d', strtotime($request->date));
            if($holidayDefault == $holidayRequest){
                $sttHoliday = $typeId['holiday'];
                break;
            }
        }
        //Kiểm tra co phải ngày nghĩ đột xuất k
        if ($sttHoliday  == 1){
            $holidays = Holiday::with('type')->get();
            foreach ($holidays as $holiday){
                $holiday->type->name;
                $holidayAdded = $holiday->date->format('Y-m-d');
                $holidayRequest = date('Y-m-d', strtotime($request->date));
                if($holidayAdded == $holidayRequest){
                    $sttHoliday = $typeId[$holiday->type->name];
                }
            }
        }

        $overtime->process_id = $request->process_id;
        $overtime->date = $request->date;
        $overtime->start_time = $request->start_time;
        $overtime->end_time = $request->end_time;
        $overtime->day_type_id = $sttHoliday;
        $overtime->total_time = $request->total_time;
        $overtime->reason = $request->reason;

        if($overtime->save()){
            \Session::flash('msg_success', trans('overtime.msg_edit.success'));
            return redirect('ot');
        }else{
            \Session::flash('msg_fail', trans('overtime.msg_edit.fail'));
            return back()->with(['ot' => $overtime]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $overtime = Overtime::where('id', $id)->first();
        $overtime->delete_flag = 1;
        $overtime->save();
        \Session::flash('msg_success', trans('common.delete.success'));
        return redirect('ot');
    }
}
