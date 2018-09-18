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
use App\Models\OvertimeType;
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

    public function indexPO()
    {   
        $user_id=Auth::user()->id;
        $id_rw = OvertimeStatus::where('name','Reviewing')->first()->id;

        $project = Process::where('employee_id', $user_id)->where('delete_flag', 0)->with(['role' => function($query) {
            $query->where('name', 'PO');
        }])->get()->toArray();
        // dd($project);
        $project_po = [];
        foreach($project as $val){
            if($val['role'] != null){
                $project_po[] = $val['project_id'];
            }
        }
        // dd($project_po);
        $ot = Overtime::whereIn('project_id', $project_po)->with('employee', 'type', 'status', 'project')->orderBy('updated_at', 'desc')->get()->toArray();
        
        $ot_dev = [];
        $ot_po = [];
        foreach($ot as $val){
            $role = Process::where('employee_id', $val['employee_id'])->where('project_id', $val['project_id'])->with('role')->get()->pluck('role')->pluck('name')->toArray();
            
            if($role){
                if($role[0] =='Dev'){
                    $ot_dev[] = $val;
                }
                if($role[0] =='PO'){
                    $ot_po[] = $val;
                }
            }
            
        }
        $ot_hr = Overtime::where('project_id', null)->orderBy('updated_at', 'desc')->with('employee', 'type', 'status', 'project')->get()->toArray();
        // dd($ot_hr);
        $is_manager = Employee::where('id',$user_id)->get()->pluck('is_manager')->toArray()[0];
        // dd($ot_dev);
        if($is_manager){
            foreach($ot_po as $value){
                if($value['status']['name'] =='Not yet' ){
                    $overtime = Overtime::where('id',$value['id'])->first();
                    $overtime->overtime_status_id = $id_rw;
                    $overtime->save();
                }
            }

            return view('overtime.po_list',[
                'ot_po' => $ot_po,
                'ot_dev' => $ot_dev,
                'ot_hr' => $ot_hr,
                ]);
        }
        return view('overtime.po_list',[
            'ot_dev' => $ot_dev,
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
        $ot_status = OvertimeStatus::all();
        $ot_type = OvertimeType::all();
        $request['user_id'] = $id;
        $request['oldmonth'] = $oldmonth;
        if (!isset($request['number_record_per_page'])) {
            $request['number_record_per_page'] = config('settings.paginate');
        }
        $overtime = $this->searchEmployeeService->searchOvertime($request);
        $overtime = $overtime->paginate($request['number_record_per_page']);
        $overtime->setPath('');
        
        $normal = 0;
        $weekend = 0;
        $holiday = 0;
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
        $objProject = Process::where('employee_id',$id)->get();
//        $objOvertimeType = OvertimeType::all();
        return view('overtime.add',compact('objProject','objOvertimeType'));
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
            $overtime->project_id = $request->project_id;
        }else{
            $overtime->project_id = null;
        }
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
        $overtime->date = $request->date;
        if ($sttHoliday == 1){
            $overtime->overtime_type_id = 3;
        }elseif(date('N', strtotime($request->date)) >= 6){
            $overtime->overtime_type_id = 2;
        }else{
            $overtime->overtime_type_id = 1;
        }
        $overtime->start_time = $request->start_time;
        $overtime->end_time = $request->end_time;
        $overtime->total_time = $request->total_time;
//        $overtime->overtime_type_id = $request->overtime_type_id;
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
    public function update(Request $request, $id)
    {

        $overtime = Overtime::where('delete_flag',0)->find($id);
        if ($overtime == null) {
            return abort(404);
        }
        $overtime->project_id = $request->project_id;
        $overtime->date = $request->ot_date;
        $overtime->start_time = $request->start_time;
        $overtime->end_time = $request->end_time;
        //kiểm tra co phải ngày nghĩ lễ không.
        $holiday = HolidayDefault::all();
        $sttHoliday = "";
        foreach ($holiday as $holiday){
            $holidayDefault = date_format($holiday->date,"m-d");
            $holidayRequest = date('m-d', strtotime($request->ot_date));
            if($holidayDefault == $holidayRequest){
                $sttHoliday = 1;
            }
        }
        //Kiểm tra co phải ngày nghĩ lễ đột xuất k
        if ($sttHoliday == ""){
            $holiday = Holiday::all();
            foreach ($holiday as $holiday){
                $holidayDefault = date_format($holiday->date,"y-m-d");
                $holidayRequest = date('y-m-d', strtotime($request->ot_date));
                if($holidayDefault == $holidayRequest){
                    $sttHoliday = 1;
                }
            }
        }
        if ($sttHoliday == 1){
            $overtime->overtime_type_id = 3;
        }elseif(date('N', strtotime($request->ot_date)) >= 6){
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
