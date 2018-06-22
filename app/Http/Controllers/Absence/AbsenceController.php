<?php

namespace App\Http\Controllers\Absence;

use App\Absence\AbsenceService;
use App\Http\Controllers\Controller;
use App\Models\Absence;
use App\Models\AbsenceStatus;
use App\Models\AbsenceType;

use App\Models\Employee;
use App\Service\AbsencePoTeamService;
use Carbon\Carbon;
use App\Models\Confirm;
use App\Models\Process;
use App\Models\Role;
use App\Service\SearchConfirmService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use PhpOffice\PhpSpreadsheet\Calculation\DateTime;


class AbsenceController extends Controller
{
    public $id_employee;
    public $absencePoTeamService;
    private $searchConfirmService;

    public function __construct(SearchConfirmService $searchConfirmService, AbsencePoTeamService $absencePoTeamService)
    {
        $this->searchConfirmService = $searchConfirmService;
        $this->absencePoTeamService = $absencePoTeamService;
    }

    public function confirmRequest($id, Request $request)
    {
        $absenceType = AbsenceType::where('name', '!=', config('settings.status_common.absence_type.subtract_salary_date'))->get();
        $idPO = Role::where('name', '=', config('settings.Roles.PO'))->first()->id;
        $absenceStatus = AbsenceStatus::all();

        if (!isset($request['number_record_per_page'])) {
            $request['number_record_per_page'] = config('settings.paginate');
        }
        $projects = Process::select('processes.project_id', 'projects.name')
            ->join('projects', 'projects.id', '=', 'processes.project_id')
            ->where('processes.employee_id', '=', $id)
            ->where('processes.role_id', '=', $idPO)
            ->where('processes.delete_flag', '=', '0')
            ->get();
        $listConfirm = $this->searchConfirmService->searchConfirm($request)->where('confirms.employee_id', '=', $id)
            ->where('confirms.is_process', '=', 1)
            ->where('confirms.delete_flag', '=', 0)
            ->orderBy('confirms.id', 'desc')
//            ->get();
            ->paginate($request['number_record_per_page'], ['confirms.*']);
//        dd($listConfirm);
        $listConfirm->setPath('');
//        dd($request);
        $param = (Input::except(['page', 'is_employee']));
//        dd($param);
        return view('absence.po_project', compact('absenceType', 'projects', 'listConfirm', 'idPO', 'id', 'absenceStatus', 'param'));
    }

    public function confirmRequestAjax($id, Request $request)
    {
        if ($request->ajax()) {
            $typeConfirm = $request->type_confirm;
            $actionConfirm = $request->action_confirm;
            $idConfirm = $request->id_confirm;
            $rejectReason = $request->reason;

            $idAccept = AbsenceStatus::where('name', '=', 'Accepted')->first()->id;
            $idReject = AbsenceStatus::where('name', '=', 'Rejected')->first()->id;

            if($typeConfirm === 'absence'){
                if($actionConfirm === 'accept'){
                    $this->updateConfirm($idConfirm, $idAccept, "");
                    return response(['msg' => 'Được Nghỉ']);
                } else {
                    $this->updateConfirm($idConfirm, $idReject, $rejectReason);
                    return response(['msg' => 'Không Được Nghỉ']);
                }
            } else {
                if($actionConfirm === 'accept'){
                    $this->updateConfirm($idConfirm, $idReject, "");
                    return response(['msg' => 'Không Được Nghỉ']);
                } else {
                    $this->updateConfirm($idConfirm, $idAccept, $rejectReason);
                    return response(['msg' => 'Được Nghỉ']);
                }
            }
        }
        return response(['msg' => 'Failed']);
    }

    public function updateConfirm($idConfirm, $idAbsenceStatus, $rejectReason)
    {
        $confirm = Confirm::find($idConfirm);
        $confirm->absence_status_id = $idAbsenceStatus;
        if ($rejectReason != "") {
            $confirm->reason = $rejectReason;
        }
        $confirm->save();

        $absence = $confirm->absence;
        $absence->is_deny = 0;
        $absence->save();
    }


    public function index(Request $request){
        $id = \Illuminate\Support\Facades\Auth::user()->id;
        $dateNow = new DateTime;
        $year = $dateNow->format('Y');
    	$abc = new AbsenceService();

        $tongSoNgayDuocNghi = $abc->totalDateAbsences($id,$year);
        $soNgayPhepDu = $abc->numberAbsenceRedundancyOfYearOld($id,$year-1);
        $soNgayPhepCoDinh = $abc->absenceDateOnYear($id, $year) + $abc->numberAbsenceAddPerennial($id,$year);

        $tongSoNgayDaNghi = $abc->numberOfDaysOff($id,$year,0,2);
        $soNgayTruPhepDu = $abc->subRedundancy($id, $year);
        $soNgayTruPhepCoDinh = $abc->subDateAbsences($id, $year);

        $absences = [
                        "1"=>$tongSoNgayDuocNghi, 
                        "2"=>$soNgayPhepCoDinh,
                        "3"=>$soNgayPhepDu,
                        "4"=>$tongSoNgayDaNghi,
                        "5"=>$soNgayTruPhepCoDinh,
                        "6"=>$soNgayTruPhepDu,
                    ];
        return view('vangnghi.list', compact('absences'));
    }

    public function create()
    {
        $id_employee=Auth::user()->id;

        $curDate= date_create(Carbon::now()->format('Y-m-d'));
        $dayBefore = ($curDate)->modify('-15 day')->format('Y-m-d');
        $dayAfter = ($curDate)->modify('+15 day')->format('Y-m-d');

        $objEmployee = Employee::select('employees.*', 'teams.name as team_name')
            ->join('teams', 'employees.team_id', '=', 'teams.id')
            ->where('employees.delete_flag', 0)->findOrFail($id_employee)->toArray();

        $objPO = Employee::SELECT('employees.name as PO_name', 'projects.name as project_name')
            ->JOIN('processes', 'processes.employee_id', '=', 'employees.id')
            ->JOIN('projects', 'processes.project_id', '=', 'projects.id')
            ->JOIN('roles', 'processes.role_id', '=', 'roles.id')
            ->whereIn('processes.project_id', function ($query) use ($id_employee,$dayBefore)  {
                $query->select('project_id')
                    ->from('processes')
                    ->where('employee_id', '=', $id_employee)
                    ->whereDate('processes.start_date', '>', $dayBefore);
            })
            ->WHERE('employees.delete_flag', '=', 0)
            ->WHERE('roles.name', 'like', 'po')
            ->get()->toArray();
        $Absence_type = AbsenceType::select('id', 'name')->get()->toArray();

        return view('absences.formVangNghi', ['objPO' => $objPO, 'objEmployee' => $objEmployee,'Absence_type' => $Absence_type]);
    }

    public function store(AbsenceAddRequest $request){
        $absence_form = new Absence;
        $absence_form->employee_id = Auth::user()->id;
        $absence_form->absence_type_id = $request->absence_type_id;

        $absence_form->name = $request->name;
        $absence_form->startwork_date = $request->startwork_date;
        $absence_form->endwork_date = $request->endwork_date;
        $date = new DateTime;
        $date = $date->format('Y-m-d H:i:s');
        if(strtotime($absence_form->to_date) < strtotime($date)){
            $absence_form->is_late = 0;
        }else{
            $absence_form->is_late = 1;
        }

        $absence_form->created_at = new DateTime();
        $absence_form->delete_flag = 0;

        if($absence_form->save()){
            \Session::flash('msg_success', 'Account successfully created!!!');
            return redirect('absences');
        }else{
            \Session::flash('msg_fail', 'Account failed created!!!');
            return back()->with(['absences' => $absence_form]);
        }
    }
    public function show($id, Request $request){

    }
    public function edit($id){

    }
    public function update(Request $request, $id){

    }
    public function destroy($id, Request $request){

    }

    // function create by Quy.
    public function showListAbsence(Request $request){
        $getIdUserLogged = Auth::id();
        $getAllAbsenceStatus = AbsenceStatus::all();
        $getAllAbsenceTypes = AbsenceType::all();

//        $getAllAbsenceInConfirm = Confirm::where('employee_id',$getIdUserLogged)
//            ->orderBy('id', 'DESC')->get();
        $getAllAbsenceInConfirm = $this->absencePoTeamService->searchAbsence($request, $getIdUserLogged)->orderBy('id', 'DESC')->get();
        return view('absences.poteam', compact('getAllAbsenceInConfirm','getAllAbsenceStatus','getAllAbsenceTypes'));
    }
    public function denyPOTeam(Request $request){
        return $this->absencePoTeamService->poTeamAcceptOrDenyAbsence($request);
    }
    public function doneConfirm(Request $request){
        return $this->absencePoTeamService->poTeamAcceptAbsenceForm($request);
    }
}
