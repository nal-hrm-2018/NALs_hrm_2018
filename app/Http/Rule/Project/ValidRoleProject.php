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
use App\Models\Role;

class ValidRoleProject implements Rule
{
    private $message;
    private $processes;

    public function __construct($processes)
    {
        $this->processes = $processes;
    }

    public function passes($attribute, $value)
    {
        $id_po = (string)Role::select('id')->where('delete_flag', 0)->where('name', '=', config('settings.Roles.PO'))->first()->id;
        if ($id_po === $value) {
            if (hasDupeProject($this->processes, 'role_id', $value)) {
                $this->message = "Project can't has over one PO .";
                return false;
            }
            return true;
        }
        return true;
    }

    public function message()
    {
        return $this->message;
    }
}