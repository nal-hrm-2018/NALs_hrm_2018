<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 5/8/2018
 * Time: 3:01 PM
 */

namespace App\Http\Rule\Project;

use App\Models\Employee;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\Team;


class ValidDupeMember implements Rule
{
    private $message;
    private $processes;
    private $start_date_process;
    private $end_date_process;
    private $delete_flag;

    public function __construct(
        $processes,
        $start_date_process,
        $end_date_process,
        $delete_flag)
    {
        $this->processes = $processes;
        $this->start_date_process = $start_date_process;
        $this->end_date_process = $end_date_process;
        $this->delete_flag=$delete_flag;
    }

    public function passes($attribute, $value)
    {
        if(!is_null($this->delete_flag)&&$this->delete_flag!=='0')
        {
            return true;
        }
        // check member duplication
        $employee_name = Employee::select('name')->where('id', $value)->first();
        if (!is_null($employee_name)) {
            $employee_name = $employee_name->name;
        } else {
            $this->message = trans('validation.custom.employye.invalid_id');
            return false;
        }
        $error = hasDupeProject(
            $this->processes,
            $this->start_date_process,
            $this->end_date_process,
            'employee_id',
            $value,
            $employee_name);
        if (!empty($error)) {
            $this->message = $error;
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
        return $this->message;
    }
}