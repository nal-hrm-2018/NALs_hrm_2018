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
        $ot_type = OvertimeType::all();
        $user_id=Auth::user()->id;
        $id_re = OvertimeStatus::where('name','Reviewing')->first()->id;
        $id_no = OvertimeStatus::where('name','Not yet')->first()->id;

        $project = Process::where('employee_id', $user_id)->where('delete_flag', 0)->with(['role' => function($query) {
            $query->where('name', 'PO');
        }])->get()->toArray();
        
        $project_po = [];
        foreach($project as $val){
            if($val['role'] != null){
                $project_po[] = $val['project_id'];
            }
        }

        $overtime = [];
        $is_manager = Employee::where('id',$user_id)->get()->pluck('is_manager')->toArray()[0];
        $ot = Overtime::with('employee', 'type', 'status', 'project')->orderBy('updated_at', 'desc')->get()->toArray();
        foreach($ot as $val){
            $role = Process::where('employee_id', $val['employee_id'])->where('project_id', $val['project_id'])->with('role')->get()->pluck('role')->pluck('name')->toArray();
            if(count($role)){
                $role = $role[0];
            }else{
                $role = '';
            }
            if($role == 'Dev'){
                if(in_array($val['project_id'], $project_po)){
                    $overtime[] = $val;
                }
            }else{
                if($is_manager){
                    $overtime[] = $val;
                }
            }
            
        }
        $ot_review = [];
        foreach($overtime as $val){
            if($val['status']['id'] == $id_re || $val['status']['id'] == $id_no){
                $ot_review[] = $val;
            }
        }

        $overtime = [];
        
        $oldmonth = date('d');
        $oldmonth = date("Y-m-d", strtotime('-'.$oldmonth.' day'));
        $request['oldmonth'] = $oldmonth;
        $ot = $this->searchEmployeeService->searchOvertimePO($request)->get();
        
        if (!isset($request['number_record_per_page'])) {
            $request['number_record_per_page'] = config('settings.paginate');
        }
        // dd($ot);
        foreach($ot as $val){
            $role = Process::where('employee_id', $val['employee_id'])->where('project_id', $val['project_id'])->with('role')->get()->pluck('role')->pluck('name')->toArray();
            if(count($role)){
                $role = $role[0];
            }else{
                $role = '';
            }
            if($role == 'Dev'){
                if(in_array($val['project_id'], $project_po)){
                    $overtime[] = $val;
                }
            }else{
                if($is_manager){
                    $overtime[] = $val;
                }
            }
            
        }
        $ot_done = [];
        foreach($overtime as $val){
            if($val['status']['id'] == $id_re || $val['status']['id'] == $id_no){
               
            }else{
                $ot_done[] = $val;
            }
        }
        
        foreach($ot_review as $value){
            if($value['status']['name'] =='Not yet' ){
                $overtime = Overtime::where('id',$value['id'])->first();
                $overtime->overtime_status_id = $id_re;
                $overtime->save();
            }
        }
        return view('overtime.po_list',[
            'ot' => $ot_done,
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
        $OT[] = Process::where('employee_id',$id)->with('project.overtime')->get();
        return redirect()->route('po-ot',['OT'=>$OT]);
    }

    public function rejectOT(OvertimeRequest $request,$id){
        $id_emp = Auth::user()->id;
        $OT[] = Process::where('employee_id',$id_emp)->with('project.overtime')->get();
        $correct_total_time = $request->correct_total_time;
        $overtime = Overtime::where('id',$id)->first();
        $total_time = $overtime->total_time;
        if($total_time<$correct_total_time){
            \Session::flash('msg_fail', trans('overtime.reject.fail'));
            return redirect()->route('po-ot',['OT'=>$OT]);
        }elseif($total_time==0){
            $overtime->overtime_status_id = OvertimeStatus::where('name','Rejected')->first()->id;
            $overtime->correct_total_time = 0;
        }else{
            $overtime->overtime_status_id = OvertimeStatus::where('name','Rejected')->first()->id;
            $overtime->correct_total_time = $correct_total_time;
        }
        $overtime->save();
        return redirect()->route('po-ot',['OT'=>$OT]);
    }
    public function indexHR(Request $request)
    {
        if (!isset($request['number_record_per_page'])) {
            $request['number_record_per_page'] = config('settings.paginate');
        }
        $employees = $this->searchEmployeeService->searchEmployee($request)->orderBy('id', 'asc')->with('overtime');
//        $teams = Team::select('id', 'name')->where('delete_flag', 0)->get();
        $projects = Project::select('id', 'name')->where('delete_flag', 0)->get();
        $employees = $employees->paginate($request['number_record_per_page']);
        $employees->setPath('');
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
        $ot_type = OvertimeType::all();
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
            if($val->status->name = 'Accepted' || $val->status->name = 'Rejected'){
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

        //kiểm tra co phải ngày nghĩ lễ không.
        $holiday = HolidayDefault::all();
        $sttHoliday = 0;
        foreach ($holiday as $holiday){
            $holidayDefault = date_format($holiday->date,"m-d");
            $holidayRequest = date('m-d', strtotime($request->date));
            if($holidayDefault == $holidayRequest){
                $sttHoliday = $typeId['holiday'];
                break;
            }
        }
        //Kiểm tra co phải ngày nghĩ lễ đột xuất k
        if ($sttHoliday){
            $holidays = Holiday::with('type')->get();

            dd($holidays);
            die();
            foreach ($holidays as $holiday){
                $holidayAdded = date_format($holiday->date,"y-m-d");
                $holidayRequest = date('y-m-d', strtotime($request->date));
                if($holidayDefault == $holidayRequest){
                    // $sttHoliday = $typeId[];
                }
            }
        }
        die();
        $overtime->date = $request->date;
        if ($sttHoliday == 1){
            $overtime->day_type_id = 3;
        }elseif(date('N', strtotime($request->date)) >= 6){
            $overtime->day_type_id = 2;
        }else{
            $overtime->day_type_id = 1;
        }
        $overtime->start_time = $request->start_time;
        $overtime->end_time = $request->end_time;
        $overtime->total_time = $request->total_time;
//        $overtime->overtime_type_id = $request->overtime_type_id;
        $overtime->reason = $request->reason;
        $my_ot = Overtime::where('employee_id',$id)->get();

        foreach($my_ot as $my_ot){
            if($my_ot->date == $request->date.' 00:00:00'){
                \Session::flash('msg_fail', trans('overtime.msg_add.duplicate'));
                return back()->withInput();
            }
        }
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
        $ot_history = Overtime::where('delete_flag', 0)->find($id);
        $projects = Project::whereHas('processes',  function($q) use($ot_history){
            $q->where('employee_id', $ot_history->employee_id );
        })->get();
        $overtime_type = OvertimeType::all();
        if ($ot_history == null) {
            return abort(404);
        }
        return view('overtime.edit',[
            'ot_history'=> $ot_history,
            'projects' => $projects,
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
        $overtime->project_id = $request->project_id;
        $overtime->date = $request->date;
        $overtime->start_time = $request->start_time;
        $overtime->end_time = $request->end_time;
        //kiểm tra co phải ngày nghĩ lễ không.
        $holiday = HolidayDefault::all();
        $sttHoliday = "";
        foreach ($holiday as $holiday){
            $holidayDefault = date_format($holiday->date,"m-d");
            $holidayRequest = date('m-d', strtotime($request->date));
            if($holidayDefault == $holidayRequest){
                $sttHoliday = 1;
            }
        }
        //Kiểm tra co phải ngày nghĩ lễ đột xuất k
        if ($sttHoliday == ""){
            $holiday = Holiday::all();
            foreach ($holiday as $holiday){
                $holidayDefault = date_format($holiday->date,"y-m-d");
                $holidayRequest = date('y-m-d', strtotime($request->date));
                if($holidayDefault == $holidayRequest){
                    $sttHoliday = 1;
                }
            }
        }
        if ($sttHoliday == 1){
            $overtime->overtime_type_id = 3;
        }elseif(date('N', strtotime($request->date)) >= 6){
            $overtime->overtime_type_id = 2;
        }else{
            $overtime->overtime_type_id = 1;
        }
        // $overtime->overtime_type_id = $request->overtime_type_id;
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
        $overtime = Overtime::where('id', $id)->where('delete_flag', 0)->first();
        $overtime->delete_flag = 1;
        $overtime->save();
        \Session::flash('msg_success', trans('common.delete.success'));
        return redirect('ot');
    }
}
