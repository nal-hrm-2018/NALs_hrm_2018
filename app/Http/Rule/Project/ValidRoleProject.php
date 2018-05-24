<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 5/8/2018
 * Time: 3:01 PM
 */

namespace App\Http\Rule\Project;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\Team;
class ValidRoleProject implements Rule
{
    public function __construct($id_members)
    {
    }

    public function passes($attribute, $value)
    {

    }

    public function message()
    {
        return trans('team.msg_content.msg_dupe_po_member');
    }
}