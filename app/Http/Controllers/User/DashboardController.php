<?php

namespace App\Http\Controllers\User;

use App\Models\Process;
use App\Models\Project;
use Illuminate\Foundation\Console\EventMakeCommand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id_emp=Auth::user()->id;
        if (Employee::find($id_emp)->hasRole('PO')){
            $projects= Project::where('status_id', '!=', 5)->with('status')->orderBy('status_id', 'desc')->get();
            $processes = Process::where('employee_id', $id_emp)->with('project','role','project.status')->get();
            $processes = $processes->where('project.status_id', '!=', 5);

//            dd($processes[0]->project_id);


            $projects_id = Process::select('project_id')->where('employee_id', $id_emp)->get();
            $projects_emp = [];
            foreach ($projects_id as $project_id){
                $projects_emp[] = Process::select('employee_id', 'project_id', 'role_id')->with('employee','role')->where('project_id', $project_id['project_id'])->orderBy('role_id')->get();
            }

            return view('admin.module.index.index',[
                'processes' => $processes,
                'projects'=> $projects,
                'role' => 'PO',
                'projects_emp' => $projects_emp
            ]);
        }
        $objmEmployee = Employee::find(Auth::user()->id);
        return view('admin.module.index.index',[
            'objmEmployee' => $objmEmployee,
            'role' => '',
        ]);
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
    public function destroy($id)
    {
        //
    }

    public static function getByUserName($id)
    {
        return DB::table('employees')->where('id','=',$id)->first();
    }

}
