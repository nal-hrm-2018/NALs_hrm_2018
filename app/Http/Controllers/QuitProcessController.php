<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service\SearchEmployeeService;
use App\Models\Team;
use App\Models\Role;
use App\Models\Employee;

class QuitProcessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $searchEmployeeQuit;
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
            foreach($employee->toArray()['contractual_historys'] as $history){
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
        //
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
        //
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
