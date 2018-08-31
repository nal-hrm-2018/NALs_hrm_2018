<?php

namespace App\Http\Controllers\OT;

use App\Http\Controllers\Controller;
use App\Models\Overtime;
use App\Models\Process;
use App\Models\OvertimeStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OTController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $objOT;
    public function __construct (Overtime $objOT)
    {
        $this->objOT=$objOT;
    }

    public function indexPO()
    {
        $id=Auth::user()->id;
        $OT[] = Process::where('employee_id',$id)->with('project.overtime')->get();
        return view('overtime.po_list',['OT'=>$OT]);
    }

    public function acceptOT($id){
        $overtime = Overtime::find($id);
        $status_ot = OvertimeStatus::where('name','Accepted')->first();
        $overtime->overtime_status_id = $status_ot->id;
        $overtime->save();
        $id=Auth::user()->id;
        $OT[] = Process::where('employee_id',$id)->with('project.overtime')->get();
        return redirect()->route('po-ot',['OT'=>$OT]);
    }

    public function rejectOT(Request $request,$id){
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
        }else{
            $overtime->overtime_status_id = OvertimeStatus::where('name','Accepted')->first()->id;
            $overtime->correct_total_time = $correct_total_time;
        }
        $overtime->save();
        return redirect()->route('po-ot',['OT'=>$OT]);
    }
    public function indexHR()
    {
        return view('overtime.hr_list');
    }

    public function index()
    {
        $id=Auth::user()->id;
        $newmonth = date('d');
        $newmonth = date("Y-m-d", strtotime('-'.$newmonth.' day'));
        $ot = Overtime::select()->where('employee_id', $id)->where('date', '>', $newmonth)->with('status', 'type', 'project', 'employee')->get()->sortBy('date');
        $normal = 0;
        $weekend = 0;
        $holiday = 0;
        foreach($ot as $val){
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
        $time = ['normal' => $normal,'weekend' => $weekend,'holiday' => $holiday];
        return view('overtime.list', [
            'ot' => $ot,
            'time' => $time,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('overtime.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        return view('overtime.edit');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
