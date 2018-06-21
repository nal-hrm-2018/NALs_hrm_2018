<?php

namespace App\Http\Controllers\Absence;

use App\Http\Controllers\Controller;
use App\Models\Confirm;
use App\Models\Employee;
use App\Absence\AbsenceService;
use App\Models\AbsenceStatus;
use App\Models\AbsenceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AbsenceController extends Controller
{
    public function __construct(){

    }
    public function index(Request $request){
    	$abc = new AbsenceService();
    	/*dd($abc->soNgayNghiPhep(1,2017,0));
    	dd($abc->soNgayDuocNghiPhep(1,2017));*/
        return view('vangnghi.list');
    }

    public function create()
    {

    }

    public function store(Request $request){

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
