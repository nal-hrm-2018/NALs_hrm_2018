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
use App\Models\Employee;

class ValidRoleProject implements Rule
{
    private $message;
    private $processes;
    private $start_date_process;
    private $end_date_process;
    private $delete_flag;
    private $employee_id;

    public function __construct(
        $processes,
        $start_date_process,
        $end_date_process,
        $delete_flag,
        $employee_id
    )
    {
        $this->processes = $processes;
        $this->start_date_process = $start_date_process;
        $this->end_date_process = $end_date_process;
        $this->delete_flag=$delete_flag;
        $this->employee_id=$employee_id;
    }

    public function passes($attribute, $value)
    {
        if(!is_null($this->delete_flag)&&$this->delete_flag!=='0')
        {
            return true;
        }
        $employee_name = Employee::select('name')->where('id', $this->employee_id)->first();
        if (!is_null($employee_name)) {
            $employee_name = $employee_name->name;
        } else {
            $this->message = trans('validation.custom.employee.invalid_id');
            return false;
        }

        $id_po = Role::select('id')->where('delete_flag', 0)->where('name', '=', config('settings.Roles.PO'))->first();
        if(!is_null($id_po)){
            $id_po = (string)Role::select('id')->where('delete_flag', 0)->where('name', '=', config('settings.Roles.PO'))->first()->id;
        }else{
            $this->message= "Role PO not exist in database";
            return false;
        }

        if ($id_po === $value) {
            $error = hasDupeProject(
                $this->processes,
                $this->start_date_process,
                $this->end_date_process,
                'role_id',
                $value,
                $employee_name);
            if (!empty($error)) {
                $this->message = $error;
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