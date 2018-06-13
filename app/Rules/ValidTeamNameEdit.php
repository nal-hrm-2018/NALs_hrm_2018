<?php

namespace App\Rules;

use App\Models\Team;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class ValidTeamNameEdit implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->id=$id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        /*$rolePoInRole = Team::select('teams.name')
            ->join('employees','teams.id','=','employees.team_id')
            ->where('employees.email',Auth::user()->email)->first();
        $userTest = $rolePoInRole->name;

        $queryGetNameTeamTable = Team::where('name', $value)->first();

        if (isset($queryGetNameTeamTable->name) && !($value==$userTest)) {
            return false;
        }
        return true;*/

        $obj = Team::select('name')
            ->where('name', $value)
            ->where('id','<>', $this->id)->first();
        if ($obj != null) {
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
