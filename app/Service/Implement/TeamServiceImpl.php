<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 5/8/2018
 * Time: 9:18 AM
 */

namespace App\Service\Implement;


use App\Service\CommonService;
use App\Service\TeamService;
use App\Models\Team;
use App\Models\Employee;
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
            $po = Employee::findOrFail($id_po);

            $team = new Team();
            $team->name = $team_name;

            $members = Employee::where('delete_flag', 0)->whereIn('id', (array)$id_members)->get();
            //check old role member is PO
            foreach ($members as $member) {
                if (config('settings.Roles.PO') === Role::findOrfail($member->role_id)->name) {
                    $member->role_id = null;
                }
            }

            DB::beginTransaction();
            $team->save();

            $po->team_id = $team->id;
            $roles = Role::where('delete_flag', 0)->pluck('id', 'name');
            $role = null;
            if (!$roles->isEmpty()) {
                $role = $roles[config('settings.Roles.PO')];
            }
            $po->role_id = $role;
            $po->save();

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
            session()->flash(trans('team.msg_error'), trans('team.msg_content.msg_error_add_team'));
        }
        return false;
    }
}