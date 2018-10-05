<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service\SearchEmployeeService;
use App\Models\Team;
use App\Models\Role;
use App\Models\Employee;
use App\Models\Quit;
use App\Http\Requests\QuitAddRequest;
use App\Http\Requests\QuitEditRequest;

class QuitProcessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $searchEmployeeQuit;
    protected $objQuit;
    public function __construct(SearchEmployeeService $searchEmployeeQuit)
    {
        $this->searchEmployeeQuit = $searchEmployeeQuit;
    }
    public function index(Request $request)
    {
        $status = [0=> trans('employee.profile_info.status_active'), 1=>trans('employee.profile_info.status_quited'),2=> trans('employee.profile_info.status_expired')];
        $teams = Team::select('id', 'name')->where('delete_flag', 0)->get();
        $roles = Role::select('id', 'name')->where('delete_flag', 0)->get();
        $employees = $this->searchEmployeeQuit->searchEmployee($request)->where('work_status',1)->get();
        foreach($employees as $employee){
            foreach($employee->toArray()['contractual_history'] as $history){
                $employee->history = $history['end_date'];
            }
        }
        // dd($employees->toArray());
        if (!isset($request['number_record_per_page'])) {
            $request['number_record_per_page'] = config('settings.paginate');
        }
        return view('quit.list',compact('employees','status', 'roles', 'teams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employees = Employee::where('work_status',0)->get();
        return view('quit.add',compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuitAddRequest $request)
    {
        $employee = Employee::findOrFail($request->employee_id);
        $employee->work_status = 1; // work_status =1 là nghĩ việc
        $employee->endwork_date = $request->quit_date;
        
        $quit = new Quit();
        $quit->employee_id = $request->employee_id;
        $quit->reason = $request->reason;
        $quit->quit_date = $request->quit_date;
        
        if ($employee->save() && $quit->save()){
            \Session::flash('msg_success', trans('quit.msg_add.success'));
            return redirect('quit_process');
        }else{
            \Session::flash('msg_fail', trans('quit.msg_add.fail'));
            return back()->with(['quit_process' => $employee]);
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
        //
        $quit = Quit::where('employee_id',$id)->with('employee')->first();
        return view('quit.edit',compact('quit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(QuitEditRequest $request, $id)
    {
        
        $quit = Quit::findOrFail($id);
        $quit->reason = $request->reason;
        $quit->quit_date = $request->quit_date;

        $employee = Employee::where('id',$request->employee)->first();
        $employee->endwork_date = $request->quit_date;
        $employee->save();

        if ($quit->save()){
            \Session::flash('msg_success', trans('quit.msg_edit.success'));
            return redirect('quit_process');
        }else{
            \Session::flash('msg_fail', trans('quit.msg_edit.fail'));
            return back()->with(['quit_process' => $quit]);
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
        $employee = Employee::findOrFail($id);
        $employee->work_status = 0; // work_status =1 là nghĩ việc
        $employee->endwork_date = null;
        
        $quit = Quit::where('employee_id',$id);
        
        if ($employee->save() && $quit->delete()){
            \Session::flash('msg_success', trans('quit.msg_delete.success'));
            return redirect('quit_process');
        }else{
            \Session::flash('msg_fail', trans('quit.msg_delete.fail'));
            return back()->with(['quit_process' => $employee]);
        }
    }
}
