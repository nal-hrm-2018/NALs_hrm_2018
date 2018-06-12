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

    /*public function addNewTeam($request)
    {
        $id_po = $request->get('id_po');
        $id_members = $request->get('members');
        $team_name = $request->get('team_name');

        try {
            $po = Employee::find($id_po);
            $team = new Team();
            $team->name = $team_name;
            $members = Employee::where('delete_flag', 0)->whereIn('id', (array)$id_members)->get();
            $member_role_dev = Role::select('id')->where('name','=',config('settings.Roles.TeamDev'))->first();
            if(is_null($member_role_dev)){
                session()->flash(trans('team.msg_fails'), "Can't find role dev in database");
                return false;
            }else{
                $member_role_dev = $member_role_dev->id;
            }
            //check old role member is PO ?
            foreach ($members as $member) {
                $member_role = Role::where('delete_flag',0)->find($member->role_id);
                if (!is_null($member_role)) {
                    if (config('settings.Roles.PO') === $member_role->name) {
                        $member->role_id = $member_role_dev;
                    }
                }
            }
            DB::beginTransaction();
            $team->save();
            if (!is_null($po)) {
                $po->team_id = $team->id;
                $member_role_po = Role::select('id')->where('name','=',config('settings.Roles.PO'))->first();
                if (is_null($member_role_po)) {
                    session()->flash(trans('team.msg_fails'), "Can't find role PO in database");
                    return false;
                }else{
                    $member_role_po = $member_role_po->id;
                }
                $po->role_id = $member_role_po;
                $po->save();
            }
            if (!$members->isEmpty()) {
                foreach ($members as $member) {
                    $member->team_id = $team->id;
                    $member->save();
                }
            }
            DB::commit();
            return true;
        } catch (Exception $ex) {
            DB::rollBack();
            session()->flash(trans('team.msg_fails'), trans('project.msg_content.msg_add_error'));
        }
        return false;
    }*/
    public function addNewTeam($request)
    {
        $id_po = $request->id_po;
        $listIdMember = $request->employee;
        $team_name = $request->team_name;

        $objTeamServiceImpl = new TeamServiceImpl;
        if($objTeamServiceImpl->checkRoleOfMember($listIdMember) != null){
            session()->flash('listErrorPO', $objTeamServiceImpl->checkRoleOfMember($listIdMember));
            return false;
        }

        try {
            DB::beginTransaction();

            //save team
            $team = new Team();
            $team->name = $team_name;
            $team->save();

            //save po
            $po = Employee::find($id_po);
            if (!is_null($po)) {
                $po->team_id = $team->id;
                $member_role_po = Role::select('id')->where('name','=',config('settings.Roles.PO'))->first();
                if (is_null($member_role_po)) {
                    session()->flash(trans('team.msg_fails'), "Can't find role PO in database");
                    return false;
                }else{
                    $po->role_id = $member_role_po->id;
                }
                $po->save();
            }
            //save list member
            if($listIdMember != null){
                //update list member
                foreach ($listIdMember as $objMember){
                    $objMemberById = Employee::find($objMember['id']);
                    if ($objMemberById == null) {
                        \Session::flash('msg_fail', 'Add failed!!! Employee is not exit!!!');
                        return false;
                    } else {
                        $objMemberById->team_id = $team->id;
                        $objMemberById->role_id = (int)$objMember['role'];
                        $objMemberById->save();
                    }
                }
            }
            DB::commit();
            return true;
        } catch (Exception $ex) {
            DB::rollBack();
            session()->flash(trans('team.msg_fails'), trans('project.msg_content.msg_add_error'));
        }
        return false;
    }
    /*public function updateTeam(TeamEditRequest $request, $id)
    {
        $getAllEmployeeInTeams = Employee::select('employees.id', 'employees.name', 'roles.name as role')
            ->join('teams', 'teams.id', '=', 'employees.team_id')
            ->join('roles', 'roles.id', '=', 'employees.role_id')
            ->where('team_id', '=', Auth::user()->team_id)
            ->orderBy('employees.id', 'asc')->get();
        $findAllEmployeeInTeams = Employee::where('team_id', '=', Auth::user()->team_id);
        if (isset($id)) {
            try {
                DB::beginTransaction();
                $queryUpdateTeam = Team::find($id);
                $getPORole = Role::where('name', '=', 'PO')->firstOrFail();
                $teamName = $request->team_name;
                $poId = $request->po_name;
                $multipleEmployeesByIds = $request->employee;
                $queryUpdateTeam->name = $teamName;
                $queryUpdateTeam->save();
                if ($multipleEmployeesByIds == null){
                    $queryUpdateTeam->save();
                    return true;
                }
                else{
                    foreach ($getAllEmployeeInTeams as $getAllEmployeeInTeam){
                        $findAllEmployeeInTeams = Employee::find($getAllEmployeeInTeam->id);
                        if ($findAllEmployeeInTeams == null) {
                            \Session::flash('msg_fail', 'Edit failed!!! Employee is not exit!!!');
                            return back();
                        } else {
                            $findAllEmployeeInTeams->team_id = null;
                            $findAllEmployeeInTeams->save();
                        }
                    }

                    $findAllEmployeeInTeams->save();

                    $member_role_dev = Role::select('id')->where('name','=','Dev')->first()->id;


                    foreach ($multipleEmployeesByIds as $multipleEmployeesById) {
                        $queryUpdateEmployee = Employee::find($multipleEmployeesById);
                        if ($queryUpdateEmployee == null) {
                            \Session::flash('msg_fail', 'Edit failed!!! Employee is not exit!!!');
                            return back();
                        } else {
                            $member_role = Role::find($queryUpdateEmployee->role_id)->where('delete_flag',0);
                            if (!is_null($member_role)) {
                                if (config('settings.Roles.PO') === Role::find($queryUpdateEmployee->role_id)->name) {
                                    $queryUpdateEmployee->role_id = $member_role_dev;
                                }
                            }
                            $queryUpdateEmployee->team_id = $queryUpdateTeam->id;
                            $queryUpdateEmployee->save();
                        }
                    }
                }
                $queryUpdateRoleToEmployee = Employee::find($poId);
                $queryUpdateRoleToEmployee->team_id = $queryUpdateTeam->id;
                $queryUpdateRoleToEmployee->role_id = $getPORole['id'];
                $queryUpdateRoleToEmployee->save();
                DB::commit();
                return true;
            } catch (Exception $exception) {
                DB::rollBack();
                return false;
            }
        } else {
            return false;
        }
    }*/
    public function updateTeam(TeamEditRequest $request, $id)
    {

        try {
            DB::beginTransaction();
            //update table team
            $objTeam = Team::find($id);
            $objTeam -> name = $request->team_name;
            $objTeam ->save();

            //update table employee
            $getPORole = Role::where('name', '=', 'PO')->first();
            $getDevRole = Role::where('name', '=', 'DEV')->first();

            //delete PO old
            $objPoOld = Employee::where('role_id',$getPORole->id)
            ->where('team_id',$id)->first();
            if($objPoOld != null){
                $objPoOld -> team_id = null;
                $objPoOld -> save();
            }
            
            //update PO            
            $poId = $request->po_name;
            if($poId > 0){
                $objPoNew = Employee::find($poId);
                if($objPoNew != null){
                    $objPoNew -> team_id = $id;
                    $objPoNew -> role_id = $getPORole -> id;
                    $objPoNew -> save();
                }else{
                    \Session::flash('msg_fail', 'Edit failed!!! PO is not exit!!!');
                    return false;
                }
                
            }

            //list member
            $listMember = $request->employee;
            /*$objTeamServiceImpl = new TeamServiceImpl;

            if($objTeamServiceImpl->checkRoleOfMember($listMember) != null){
                session()->flash('listErrorPO', $objTeamServiceImpl->checkRoleOfMember($listMember));
                return false;
            }*/

            if($listMember != null){
                //list member in team
                $listMemberInTeams = Employee::select('employees.id')
                ->join('roles', 'roles.id', '=', 'employees.role_id')
                ->where('roles.name', '<>', 'PO')
                ->where('team_id', $id)->get();
                //update member in team remove
                if($listMemberInTeams != null){
                    foreach ($listMemberInTeams as $objMemberInTeams){
                        $check = true;
                        foreach ($listMember as $objMember){
                            if($objMemberInTeams->id == $objMember['id']){
                                $check = false;
                            }
                        }
                        if($check){
                            $objMemberById = Employee::find($objMemberInTeams->id);
                            if ($objMemberById == null) {
                                \Session::flash('msg_fail', 'Edit failed!!! Employee is not exit!!!');
                                return false;
                            } else {
                                $objMemberById->team_id = null;
                                $objMemberById->save();
                            }
                        }
                    }
                }
                //update list member
                foreach ($listMember as $objMember){
                    $objMemberById = Employee::find($objMember['id']);
                    if ($objMemberById == null) {
                        \Session::flash('msg_fail', 'Edit failed!!! Employee is not exit!!!');
                        return false;
                    } else {
                        if($objMemberById->role_id == $getPORole -> id){
                            $objMemberById->role_id = $getDevRole -> id;
                        }
                        $objMemberById->team_id = (int)$id;
                        $objMemberById->role_id = (int)$objMember['role'];
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
    function checkRoleOfMember($listMember){
       
        $listErrorPO = array();
        $getPORole = Role::where('name', '=', 'PO')->first();
        foreach ($listMember as $objMember){
            $objMemberById = Employee::find($objMember['id']);
            if($objMember['role'] == $getPORole->id){
                array_push($listErrorPO, "Member id: ".$objMember['id']." name: ".$objMemberById->name." role other PO");
            }
        }
        return $listErrorPO;
    }
}