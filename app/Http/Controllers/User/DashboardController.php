<?php

namespace App\Http\Controllers\User;

use App\Models\EmployeeType;
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
        $notifications = Notifications::all();
        $absences = $this->emp_absence();
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
                'absences' => $absences,
                'notifications' => $notifications,
                'processes' => $processes,
                'projects' => $projects,
                'projects_emp' => $projects_emp
            ]);
        }
        $objmEmployee = Employee::find(Auth::user()->id);
        return view('admin.module.index.index', [
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

    public function emp_absence()
    {
        $id = Auth::user()->id;
        $dateNow = new DateTime;
        $objEmployee = Employee::find($id);
        $startwork_date = (int)date_create($objEmployee->startwork_date)->format("Y");
        $endwork_date = (int)date_create($objEmployee->endwork_date)->format("Y");
        if ((int)$dateNow->format("Y") <= $endwork_date) {
            $endwork_date = (int)$dateNow->format("Y");
        }

        $status = AbsenceStatus::select()->where('name', 'accepted')->first();
        $type = AbsenceType::select()->where('name', 'annual_leave')->first();

        $year = 0;
        if ((int)$dateNow->format('Y') < $endwork_date) {
            $year = $dateNow->format('Y');
        } else {
            $year = $endwork_date;
        }

        $abc = new \App\Absence\AbsenceService();

        $tongSoNgayDuocNghi = $abc->totalDateAbsences($id, $year); // tong ngay se duoc nghi nam nay
        $soNgayPhepDu = $abc->numberAbsenceRedundancyOfYearOld($id, $year - 1); // ngay phep nam ngoai
        if ($soNgayPhepDu > 5) {
            $soNgayPhepDu = 5;
        }
        $soNgayPhepCoDinh = $abc->absenceDateOnYear($id, $year) + $abc->numberAbsenceAddPerennial($id, $year); // tong ngay co the duoc nghi


        $tongSoNgayDaNghi = $abc->numberOfDaysOff($id, $year, 0, $type->id, $status->id);// tong ngay da nghi phep ( bao gom ngay nghi co luong va` tru luong)

        $soNgayTruPhepDu = $abc->subRedundancy($id, $year); // so ngay tru vao ngay phep du nam ngoai
        $soNgayTruPhepCoDinh = $abc->subDateAbsences($id, $year); // so ngay tru vao ngay phep

        if ($year < (int)$dateNow->format('Y') || (int)$dateNow->format('m') > 6) {
            $soNgayPhepConLai = $abc->sumDateExistence($id, $year);
            if ($soNgayPhepConLai < 0) {
                $soNgayPhepConLai = 0;
            }
            $checkMonth = 1;
        } else {
            $soNgayPhepConLai = $abc->sumDateExistence($id, $year) + $abc->sumDateRedundancyExistence($id, $year);
            if ($soNgayPhepConLai < 0) {
                $soNgayPhepConLai = 0;
            }
            $checkMonth = 0;
        }
        $soNgayPhepCoDinhConLai = $abc->sumDateExistence($id, $year);
        if ($soNgayPhepCoDinhConLai < 0) {
            $soNgayPhepCoDinhConLai = 0;
        }
        $soNgayTruPhepDuConLai = $abc->sumDateRedundancyExistence($id, $year);
        if ($soNgayTruPhepDuConLai < 0) {
            $soNgayTruPhepDuConLai = 0;
        }

        $type = AbsenceType::select()->where('name', 'subtract_salary_date')->first();
        $soNgayNghiTruLuong = $abc->subtractSalaryDate($id, $year) + $abc->numberOfDaysOff($id, $year, 0, $type->id, $status->id);

        $type = AbsenceType::select()->where('name', 'unpaid_leave')->first();
        $soNgayNghiKhongLuong = $abc->numberOfDaysOff($id, $year, 0, $type->id, $status->id);

        $type = AbsenceType::select()->where('name', 'insurance_date')->first();
        $soNgayNghiBaoHiem = $abc->numberOfDaysOff($id, $year, 0, $type->id, $status->id);

        $absences = [
            "soNgayDuocNghiPhep" => $tongSoNgayDuocNghi,
            "soNgayNghiPhepCoDinh" => $soNgayPhepCoDinh,
            "soNgayPhepDu" => $soNgayPhepDu,
            "soNgayDaNghi" => $tongSoNgayDaNghi,
            "truVaoPhepCoDinh" => $soNgayTruPhepCoDinh,
            "truVaoPhepDu" => $soNgayTruPhepDu,
            "soNgayConLai" => $soNgayPhepConLai,
            "phepCoDinh" => $soNgayPhepCoDinhConLai,
            "phepDu" => $soNgayTruPhepDuConLai,
            "soNgayNghiTruLuong" => $soNgayNghiTruLuong,
            "soNgayNghiKhongLuong" => $soNgayNghiKhongLuong,
            "soNgayNghiBaoHiem" => $soNgayNghiBaoHiem,
            "checkMonth" => $checkMonth
        ];

        return $absences;
    }

}