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
use App\Models\ContractualType;
use App\Models\Overtime;
use Illuminate\Support\Facades\Input;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // private $get_absence;
    // public function __construct(NumberAbsenceService $get_absence)
    // {
    //     $this->get_absence = $get_absence;
    // }
    protected $objmNotification;
    public function __construct(Notifications $objmNotification){
        $this->objmNotification = $objmNotification;
    }
    public function index()
    {
        // $this->objmNotification->deleteNotificationExpired();
        $id_emp = Auth::user()->id;
        $notifications = Notifications::where('end_date','>=',date('Y-m-d'))
                                        ->Where('delete_flag','0')
                                        ->orderBy('id','desc')->get();
        $absences = Employee::emp_absence($id_emp);
        $notification_type = NotificationType::Where('delete_flag','0')->get();
        $overtime = Overtime::where('employee_id',$id_emp)
                    ->where('delete_flag',0)
                    ->WhereMonth('date',date('n'))
                    ->WhereYear('date',date('Y'))
                    ->get();
       
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
        $time = [
            'total_time'=> (double) ($normal+$weekend+$holiday),
            'normal' => (double) $normal,
            'weekend' => (double) $weekend,
            'holiday' => (double) $holiday
        ];
        if (Employee::find($id_emp)->hasRole('BO')) {
            $employees = Employee::Where('delete_flag','0')
                                 ->where('work_status',0)  
                                 ->where('is_employee',1)  
                                 ->get();
            $common = [
                'sum_employee'=> count($employees),
                'internship'=> $this->countEmployeeType('Internship'),
                'full-time'=> $this->countEmployeeType('FullTime'),
                'part-time'=> $this->countEmployeeType('PartTime'),
                'probationary'=>$this->countEmployeeType('Probationary'),
               ];
            $leaved_month = Employee::where('work_status', '1')
                            ->where('is_employee',1)
                            ->where('delete_flag',0)
                            ->WhereMonth('endwork_date',  date('m'))
                            ->WhereYear(('endwork_date'), date('Y'))
                            ->get();            
            $new_employee = Employee::WhereMonth(('startwork_date'), date('m'))
                            ->where('is_employee',1)
                            ->where('delete_flag',0)
                            ->WhereYear(('startwork_date'), date('Y'))
                            ->get();
            $birthday_employee = Employee::WhereMonth(('birthday'), date('m'))
                            ->where('is_employee',1)
                            ->where('delete_flag',0)
                            ->get();
            $this_month = [
                'leaved'=> count($leaved_month),
                'new' => count($new_employee),
                'birthday' => count($birthday_employee),
            ];

            $end_internship = $this->end_contract('Internship');
            $end_probatination = $this->end_contract('Probationary');
            $end_one_year = $this->end_contract('One-year');
            $end_three_year = $this->end_contract('Three-year');

            return view('admin.module.index.index', [
                'notification_type' => $notification_type,
                'absences' => $absences,
                'overtime' => $time,
                'notifications' => $notifications,
                'common'=> $common,
                // 'this_month'=> $this_month,
                'leaved_month'=> $leaved_month,
                'new_employee'=> $new_employee,
                'birthday_employee'=> $birthday_employee,
                // 'end_contract'=> $end_contract,
                'end_internship'=> $end_internship,
                'end_probatination' => $end_probatination,
                'end_one_year'=> $end_one_year,
                'end_three_year'=> $end_three_year
            ]);
        }
        if (Employee::find($id_emp)->hasRole('PO')) {
            $status_id = Status::select('id')->where('name', 'complete')->first();
            $projects = Project::where('status_id', '!=', $status_id['id'])->with('status')->orderBy('created_at', 'desc')->paginate(10);
            $param = (Input::except('page', 'is_employee'));
            $processes = Process::where('employee_id', $id_emp)->with('project', 'role', 'project.status')->get();
            $processes = $processes->where('project.status_id', '!=', $status_id['id']);
            $projects->setPath('');

            $projects_id = Process::select('project_id')->where('employee_id', $id_emp)->get();
            $projects_emp = [];
            foreach ($projects_id as $project_id) {
                $projects_emp[] = Process::select('employee_id', 'project_id', 'role_id')->with('employee', 'role')->where('project_id', $project_id['project_id'])->orderBy('role_id')->get();
            }

            return view('admin.module.index.index', [
                'notification_type' => $notification_type,
                'absences' => $absences,
                'overtime' => $time,
                'notifications' => $notifications,
                'processes' => $processes,
                'projects' => $projects,
                'projects_emp' => $projects_emp,
                'param' => $param,
            ]);
        }
        $objmEmployee = Employee::find(Auth::user()->id);
        return view('admin.module.index.index', [
            'notification_type' => $notification_type,
            'absences' => $absences,
            'overtime' => $time,
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
        $id_type = EmployeeType::select('id')->where('name', $type)
                                            ->where('delete_flag',0)
                                            ->first();
        $employee_type = Employee::Where('delete_flag','0')
                                 ->where('work_status',0)  
                                 ->where('is_employee',1)  
                                 ->where('employee_type_id', $id_type->id)
                                 ->get();
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

    public function end_contract($type){
        $end_type = Employee::select('id','name')
                 ->where('is_employee',1)
                 ->where('delete_flag',0)
                 ->whereHas('contractualType', function($query1) use($type){
                    $query1->where('name', $type);
                })
                 ->whereHas('contractualHistory', function($query2){
                    $query2->WhereYear(('end_date'), date('Y'))
                            ->WhereMonth('end_date', date('m'));
                })
                 ->get();
        return $end_type;
    }
}