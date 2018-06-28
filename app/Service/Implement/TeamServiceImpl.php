<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 5/8/2018
 * Time: 9:18 AM
 */

namespace App\Service\Implement;


use App\Http\Requests\TeamEditRequest;
use App\Service\CommonService;
use App\Service\TeamService;
use App\Models\Team;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Role;
use Exception;

class TeamServiceImpl extends CommonService
    implements TeamService
{

    public function addNewTeam($request)
    {
        $id_po = $request->get('id_po');
        $id_members = $request->get('members');
        $team_name = $request->get('team_name');

        try {
            DB::beginTransaction();
            $team = new Team();
            $team->name = $team_name;
            $team->save();

            $po = Employee::where('delete_flag',0)->find($id_po);
            if (!is_null($po)) {
                $po->team_id = $team->id;
                $po->is_manager = 1;
                $po->save();
            }
            if($id_members != null){
                foreach ($id_members as $id_member) {
                    $member = Employee::where('delete_flag', 0)->find($id_member);

                    if ($member!= null) {
                        if($member->is_manager == 1){
                            $member->is_manager = 0;
                        }
                        $member->team_id = $team->id;
                        $member->save();
                    }
                }
            }
            DB::commit();
            return true;
        } catch (Exception $ex) {
            DB::rollBack();
            session()->flash(trans('team.msg_fails'), trans('project.msg_content.msg_add_error'));
            return false;
        }
    }
    public function updateTeam( $request, $id)
    {

        try {
            DB::beginTransaction();
            //update table team
            $objTeam = Team::where('delete_flag',0)->find($id);
            $objTeam -> name = $request->team_name;
            $objTeam ->save();

            //update table employee

            //delete PO old
            $objPoOld = Employee::where('is_manager', '1')
            ->where('team_id',$id)
            ->where('delete_flag',0)->first();
            if($objPoOld != null){
                $objPoOld -> team_id = null;
                $objPoOld -> is_manager = 0;
                $objPoOld -> save();
            }
            
            //list member
            $listMember = $request->employee;

            if($listMember != null){
                //list member in team
                $listMemberInTeams = Employee::select('employees.id')
                ->where('team_id', $id)
                ->where('delete_flag',0)->get();
                //update member in team remove
                if($listMemberInTeams != null){
                    foreach ($listMemberInTeams as $objMemberInTeams){
                        $check = true;
                        foreach ($listMember as $objMember){
                            if($objMemberInTeams->id == $objMember){
                                $check = false;
                            }

                        }
                        if($check){
                            $objMemberById = Employee::where('delete_flag',0)->find($objMemberInTeams->id);
                            if ($objMemberById == null) {
                                \Session::flash('msg_fail', trans('team.team_service.msg_fail2'));
                                return false;
                            } else {
                                $objMemberById->team_id = null;
                                $objMemberById->save();
                            }
                        }
                    }
                }

                //update PO
                $poId = $request->po_name;
                if($poId > 0){
                    $objPoNew = Employee::where('delete_flag',0)->find($poId);
                    if($objPoNew != null){
                        $objPoNew -> team_id = $id;
                        $objPoNew -> is_manager  = 1;
                        $objPoNew -> save();
                    }else{
                        \Session::flash('msg_fail', trans('team.team_service.msg_fail1'));
                        return false;
                    }
                }
                //update list member
                foreach ($listMember as $objMember){
                    $objMemberById = Employee::where('delete_flag',0)->find($objMember);
                    if ($objMemberById == null) {
                        \Session::flash('msg_fail', trans('team.team_service.msg_fail2'));
                        return false;
                    } else {
                        if($objMemberById->is_manager == 1){
                            $objMemberById->is_manager = 0;
                        }
                        $objMemberById->team_id = (int)$id;
                        $objMemberById->save();
                    }
                }
            }
            DB::commit();
            return true;
        } catch (Exception $exception) {
            DB::rollBack();
            return false;
        }
    }
}