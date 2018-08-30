<?php

namespace App\Http\Controllers\User;

use App\Models\EmployeeType;
use App\Models\NotificationType;
use App\Models\Process;
use App\Models\Project;
use App\Models\Role;
use App\Models\Status;
use App\Models\Team;
use Illuminate\Foundation\Console\EventMakeCommand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Notifications;
use Illuminate\Support\Facades\Auth;
use DB;
use DateTime;
use App\Models\AbsenceStatus;
use App\Models\AbsenceType;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id_emp = Auth::user()->id;
        $notifications = Notifications::Where('flag_delete','0')->get();
        $absences = Employee::emp_absence($id_emp);
        $notification_type = NotificationType::Where('delete_flag','0')->get();
        if (Employee::find($id_emp)->hasRole('HR')) {
            $sumInternship = $this->countEmployeeType('Internship');
            $sumFullTime = $this->countEmployeeType('FullTime');
            $sumPartTime = $this->countEmployeeType('PartTime');
//          $sumContractualEmp = $this->countEmployeeType('Contractual Employee');
            $sumProbationary = $this->countEmployeeType('Probationary');
            $sum = $sumInternship + $sumFullTime + $sumPartTime + $sumProbationary;

            $leaved_employee = Employee::where('work_status', '1')->get();
            $sum_leaved = count($leaved_employee);

//            this is the new employee in this month
            $new_employee = Employee::WhereMonth(('startwork_date'), date('m'))
                ->WhereYear(('startwork_date'), date('Y'))->get();
            $sum_new = count($new_employee);
            $new_PHP = $this->countNewEmployeeTeam('PHP');
            $new_DOTNET = $this->countNewEmployeeTeam('DOTNET');
            $new_iOS = $this->countNewEmployeeTeam('iOS');
            $new_Android = $this->countNewEmployeeTeam('Android');
            $new_Tester = $this->countNewEmployeeTeam('Tester');
            $new_others = $sum_new - $new_PHP - $new_DOTNET - $new_iOS - $new_Android - $new_Tester;
            return view('admin.module.index.index', [
                'notification_type' => $notification_type,
                'absences' => $absences,
                'notifications' => $notifications,
                'sumInternship' => $sumInternship,
                'sumFullTime' => $sumFullTime,
                'sumPartTime' => $sumPartTime,
//              'sumContractualEmp' => $sumContractualEmp,
                'sumProbationary' => $sumProbationary,
                'sum' => $sum,
                'sum_leaved' => $sum_leaved,
                'sum_new' => $sum_new,
                'new_DOTNET' => $new_DOTNET,
                'new_iOS' => $new_iOS,
                'new_Android' => $new_Android,
                'new_Tester' => $new_Tester,
                'new_PHP' => $new_PHP,
                'new_others' => $new_others,
            ]);
        }
        if (Employee::find($id_emp)->hasRole('PO')) {
            $status_id = Status::select('id')->where('name', 'complete')->first();
            $projects = Project::where('status_id', '!=', $status_id['id'])->with('status')->orderBy('status_id', 'desc')->get();
            $processes = Process::where('employee_id', $id_emp)->with('project', 'role', 'project.status')->get();
            $processes = $processes->where('project.status_id', '!=', $status_id['id']);

//            dd($processes[0]->project_id);


            $projects_id = Process::select('project_id')->where('employee_id', $id_emp)->get();
            $projects_emp = [];
            foreach ($projects_id as $project_id) {
                $projects_emp[] = Process::select('employee_id', 'project_id', 'role_id')->with('employee', 'role')->where('project_id', $project_id['project_id'])->orderBy('role_id')->get();
            }

            return view('admin.module.index.index', [
                'notification_type' => $notification_type,
                'absences' => $absences,
                'notifications' => $notifications,
                'processes' => $processes,
                'projects' => $projects,
                'projects_emp' => $projects_emp
            ]);
        }
        $objmEmployee = Employee::find(Auth::user()->id);
        return view('admin.module.index.index', [
            'notification_type' => $notification_type,
            'absences' => $absences,
            'notifications' => $notifications,
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
        return DB::table('employees')->where('id', '=', $id)->first();
    }

    public function countEmployeeType($type)
    {
        $id_type = EmployeeType::select('id')->where('name', $type)->first();
        $employee_type = Employee::where('employee_type_id', $id_type->id)->get();
        $sum_type = count($employee_type);
        return $sum_type;
    }

    public function countNewEmployeeTeam($team)
    {
        $id_team = Team::select('id')->where('name', $team)->first();
        $employee_team = Employee::where('employee_type_id', $id_team->id)
            ->WhereMonth(('startwork_date'), date('m'))
            ->WhereYear(('startwork_date'), date('Y'))
            ->get();
        $sum_team = count($employee_team);
        return $sum_team;
    }
    
}