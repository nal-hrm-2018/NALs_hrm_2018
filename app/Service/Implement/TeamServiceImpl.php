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
    }

    public function updateTeam(TeamEditRequest $request, $id)
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
    }
}