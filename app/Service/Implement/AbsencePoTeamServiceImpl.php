<?php
/**
 * Created by PhpStorm.
 * User: Ngoc Quy
 * Date: 6/21/2018
 * Time: 1:35 PM
 */

namespace App\Service\Implement;


use App\Models\Confirm;
use App\Service\AbsencePoTeamService;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AbsencePoTeamServiceImpl implements AbsencePoTeamService
{

    public function poTeamAcceptOrDenyAbsence(Request $request)
    {
        $idReturn = $request['id'];
        if ($request->ajax()){
            try{
                DB::beginTransaction();
                $confirmChoose = Confirm::where('id',$request['id'])->first();
                $confirmChoose['reason'] = $request['reason'];
                $confirmChoose['absence_status_id'] = 3;
                $confirmChoose->save();
                DB::commit();
            }
            catch (Exception $ex){
                DB::rollBack();
                session()->flash(trans('team.msg_fails'), trans('project.msg_content.msg_add_error'));
            }
            finally{
                if ($request['is_deny'] == 0){
                    $msgDoneAbsence = trans('absence_po.list_po.status.no_accepted_done');
                    return response(['msg' => 'Product deleted', 'status' => 'success', 'id'=>$idReturn,'deny'=>$request['is_deny'],'html'=>$msgDoneAbsence]);
                }
                elseif ($request['is_deny'] == 1){
                    $msgDoneDeny = trans('absence_po.list_po.status.no_accepted_deny');
                    return response(['msg' => 'Product deleted', 'status' => 'success', 'id'=>$idReturn,'deny'=>$request['is_deny'], 'html'=>$msgDoneDeny]);
                }
                else{
                    return response(['msg' => 'Product deleted', 'status' => 'success', 'id'=>$idReturn,'deny'=>$request['is_deny'],'html'=>'-']);
                }
            }
        }
        return response(['msg' => 'Failed deleting the product', 'status' => 'failed']);
    }

    public function poTeamAcceptAbsenceForm(Request $request)
    {
        //absence_status_id: 1=waiting, 2=accepted , 3: rejected
        $idReturn = $request['id'];
        dd($idReturn);
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
            finally {
                if ($request['is_deny'] == 0){
                    $msgDoneAbsence = '<div class="div confirm-status">'.trans('absence_po.list_po.status.accepted_done').'</div>';
                    return response(['msg' => 'Product deleted', 'status' => 'success', 'id'=>$idReturn,'absenceStatus'=>$msgDoneAbsence,'html'=>'-']);
                }
                elseif ($request['is_deny'] == 1){
                    $msgDoneDeny = '<div class="div confirm-status">'.trans('absence_po.list_po.status.accepted_deny').'</div>';
                    return response(['msg' => 'Product deleted', 'status' => 'success', 'id'=>$idReturn,'absenceStatus'=>$msgDoneDeny, 'html'=>'-']);
                }
                else{
                    return response(['msg' => 'Product deleted', 'status' => 'success', 'id'=>$idReturn,'absenceStatus'=>'-','html'=>'-']);
                }
            }
        }
        return response(['msg' => 'Failed deleting the product', 'status' => 'failed']);
    }
}