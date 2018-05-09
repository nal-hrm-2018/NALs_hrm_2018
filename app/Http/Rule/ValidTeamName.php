<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 5/8/2018
 * Time: 3:01 PM
 */

namespace App\Http\Rule;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\Team;
class ValidTeamName implements Rule
{
    public function __construct()
    {
    }

    public function passes($attribute, $value)
    {
        $team_names = Team::where('delete_flag', 0)->pluck('name')->toArray();

        //check team name already in database
        if (in_array($value, $team_names)) {
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('team.msg_content.msg_team_name_already');
    }
}