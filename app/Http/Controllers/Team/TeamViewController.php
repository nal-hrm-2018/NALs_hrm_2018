<?php
/**
 * Created by PhpStorm.
 * User: Ngoc Quy
 * Date: 5/7/2018
 * Time: 10:51 AM
 */
namespace App\Http\Controllers\Team;
use App\Models\Employee;
use App\Models\Project;
use Illuminate\Support\Facades\DB;

class TeamViewController
{
    public function getMember($id_team)
    {
        $member=Employee::where([
            ['team_id','=', $id_team],
            ['delete_flag','=', 0]
        ])->get();

        return view('teams.view',compact('member'));
    }
}