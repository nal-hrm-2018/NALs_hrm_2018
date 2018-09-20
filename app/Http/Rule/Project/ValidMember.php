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
use App\Models\Employee;

class ValidMember implements Rule
{
    private $message;

    public function __construct()
    {
    }

    public function passes($attribute, $value)
    {
        //check member exist and not delete
        $employee_id = $value;
        $employee = Employee::select('id')->where('delete_flag', '=', 0)->where('id', $employee_id);
        if (!is_null($employee)) {
            return true;
        }
        $this->message= trans('validation.custom.employee.invalid_id');
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message;
    }
}