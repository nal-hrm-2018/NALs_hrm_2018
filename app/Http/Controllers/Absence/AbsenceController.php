<?php

namespace App\Http\Controllers\Absence;

use App\Http\Controllers\Controller;
use App\Http\Requests\AbsencesAddRequest;
use App\Models\Absence;
use App\Models\AbsenceType;
use App\Models\Employee;
use Carbon\Carbon;
use App\Models\Confirm;
use App\Absence\AbsenceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DateTime;
use Illuminate\Support\Facades\DB;
class AbsenceController extends Controller
{
    public $id_employee;

    public function __construct(){
    }
    public function index(Request $request){
        $id = \Illuminate\Support\Facades\Auth::user()->id;
        $dateNow = new DateTime;
        $year = 2017;
    	$abc = new AbsenceService();

        $tongSoNgayDuocNghi = $abc->totalDateAbsences($id,$year);
        $soNgayPhepDu = $abc->numberAbsenceRedundancyOfYearOld($id,$year-1);
        $soNgayPhepCoDinh = $abc->absenceDateOnYear($id, $year) + $abc->numberAbsenceAddPerennial($id,$year);

        $tongSoNgayDaNghi = $abc->numberOfDaysOff($id,$year,0,2);
        $soNgayTruPhepDu = $abc->subRedundancy($id, $year);
        $soNgayTruPhepCoDinh = $abc->subDateAbsences($id, $year);

        if($year < (int)$dateNow->format('Y') || (int)$dateNow->format('m') > 6){
            $soNgayPhepConLai =  $abc->sumDateExistence($id, $year);
            $checkMonth = 1;
        }else{
            $soNgayPhepConLai =  $abc->sumDateExistence($id, $year) + $abc->sumDateRedundancyExistence($id, $year);
            $checkMonth = 0;
        }
        $soNgayPhepCoDinhConLai = $abc->sumDateExistence($id, $year);
        $soNgayTruPhepDuConLai = $abc->sumDateRedundancyExistence($id, $year);

        $soNgayNghiTruLuong = $tongSoNgayDaNghi - $soNgayTruPhepDu - $soNgayTruPhepCoDinh;
        $absences = [
                        "1"=>$tongSoNgayDuocNghi, 
                        "2"=>$soNgayPhepCoDinh,
                        "3"=>$soNgayPhepDu,
                        "4"=>$tongSoNgayDaNghi,
                        "5"=>$soNgayTruPhepCoDinh,
                        "6"=>$soNgayTruPhepDu,
                        "7"=>$soNgayPhepCoDinhConLai,
                        "8"=>$soNgayTruPhepDuConLai,
                        "9"=>$soNgayPhepConLai,
                        "10"=>$soNgayNghiTruLuong
                    ];
        return view('vangnghi.list', compact('absences','checkMonth'));
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
    public function showListAbsence(){
        $getIdUserLogged = Auth::id();
        $getAllAbsenceInConfirm = Confirm::where('employee_id',$getIdUserLogged)
            ->orderBy('id', 'DESC')->get();
        return view('absences.poteam', compact('getAllAbsenceInConfirm'));
    }
    public function denyPOTeam(Request $request){
        $idReturn = $request['id'];
        if ($request->ajax()){
            try{
                DB::beginTransaction();
                $confirmChoose = Confirm::where('id',$request['id'])->first();
                $confirmChoose['reason'] = $request['reason'];
                $confirmChoose['absence_status_id'] = 3;
                $confirmChoose->save();
                DB::commit();
                if ($request['is_deny'] == 0){
                    $msgDoneAbsence = trans('absence_po.list_po.status.no_accepted_done');
                    return response(['msg' => 'Product deleted', 'status' => 'success', 'id'=>$idReturn,'html'=>$msgDoneAbsence]);
                }
                if ($request['is_deny'] == 1){
                    $msgDoneDeny = trans('absence_po.list_po.status.no_accepted_deny');
                    return response(['msg' => 'Product deleted', 'status' => 'success', 'id'=>$idReturn, 'html'=>$msgDoneDeny]);
                }
            }
            catch (Exception $ex){
                DB::rollBack();
                session()->flash(trans('team.msg_fails'), trans('project.msg_content.msg_add_error'));
            }
            return response(['msg' => 'Product deleted', 'status' => 'success', 'id'=>$idReturn,'html'=>'-']);
        }
        return response(['msg' => 'Failed deleting the product', 'status' => 'failed']);
    }
    public function doneConfirm(Request $request){
        //absence_status_id: 1=waiting, 2=accepted , 3: rejected
        $idReturn = $request['id'];
        if ($request->ajax()){
            try{
                DB::beginTransaction();
                $confirmChoose = Confirm::where('id',$request['id'])->first();
                $confirmChoose['absence_status_id'] = 2;
                $confirmChoose->save();
                DB::commit();
            }
            catch (Exception $ex){
                DB::rollBack();
                session()->flash(trans('team.msg_fails'), trans('project.msg_content.msg_add_error'));
            }
            return response(['msg' => 'Product deleted', 'status' => 'success', 'id'=>$idReturn,'html'=>'-']);
        }
        return response(['msg' => 'Failed deleting the product', 'status' => 'failed']);
    }
    public function doneDenyConfirm(Request $request){
        //absence_status_id: 1=waiting, 2=accepted , 3: rejected
        $idReturn = $request['id'];
        if ($request->ajax()){
            try{
                DB::beginTransaction();
                $confirmChoose = Confirm::where('id',$request['id'])->first();
                $confirmChoose['absence_status_id'] = 2;
                $confirmChoose->save();
                DB::commit();
            }
            catch (Exception $ex){
                DB::rollBack();
                session()->flash(trans('team.msg_fails'), trans('project.msg_content.msg_add_error'));
            }
            return response(['msg' => 'Product deleted', 'status' => 'success', 'id'=>$idReturn,'html'=>'-']);
        }
        return response(['msg' => 'Failed deleting the product', 'status' => 'failed']);
    }
}
