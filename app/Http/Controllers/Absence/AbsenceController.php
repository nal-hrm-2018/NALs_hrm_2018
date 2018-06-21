<?php

namespace App\Http\Controllers\Absence;

use App\Http\Controllers\Controller;
use App\Models\Absence;
use App\Models\AbsenceStatus;
use App\Models\AbsenceType;
use App\Models\Confirm;
use App\Models\Process;
use App\Models\Role;
use App\Service\SearchConfirmService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;


class AbsenceController extends Controller
{
    private $searchConfirmService;

    public function __construct(SearchConfirmService $searchConfirmService)
    {
        $this->searchConfirmService = $searchConfirmService;
    }

    public function confirmRequest($id, Request $request){
        $absenceType = AbsenceType::all();
        $idPO = Role::where('name', '=', 'PO')->first()->id;
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
        $listConfirm = $this->searchConfirmService->searchConfirm($request)->where('confirms.employees_id', '=', $id)
            ->where('confirms.is_process', '=', 1)
            ->where('confirms.delete_flag', '=', '0')
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

    public function updateConfirm($idConfirm, $idAbsenceStatus, $rejectReason){
        $confirm = Confirm::find($idConfirm);
        $confirm->absence_status_id = $idAbsenceStatus;
        if($rejectReason != ""){
            $confirm->reason = $rejectReason;
        }
        $confirm->save();

        $absence = $confirm->absence;
        $absence->is_deny = 0;
        $absence->save();
    }
}
