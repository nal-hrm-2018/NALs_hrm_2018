<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 5/8/2018
 * Time: 3:01 PM
 */

namespace App\Http\Rule\Project;

use App\Service\ProjectService;
use Illuminate\Contracts\Validation\Rule;
use App\Models\Employee;

class ValidManPower implements Rule
{
    private $start_date_process;
    private $end_date_process;
    private $message;
    private $projectService;
    private $except_project_id;
    private $employee_id;
    private $array_value;
    private $delete_flag;

    public function __construct(
        $start_date_process,
        $end_date_process,
        $estimate_start_date_project,
        $estimate_end_date_project,
        $except_project_id,
        $employee_id,
        $array_value,
        $delete_flag
    )
    {
        $this->projectService = app(ProjectService::class);
        $this->start_date_process = $start_date_process;
        $this->end_date_process = $end_date_process;
        $this->estimate_start_date_project = $estimate_start_date_project;
        $this->estimate_end_date_project = $estimate_end_date_project;
        $this->except_project_id=$except_project_id;
        $this->employee_id=$employee_id;
        $this->array_value=$array_value;
        $this->delete_flag=$delete_flag;
    }

    public function passes($attribute, $value)
    {
        if(!in_array($value,$this->array_value)){
            $this->message = "Value of manpower not correct !";
            return false;
        }
        if(!is_null($this->delete_flag)&&$this->delete_flag!=='0')
        {
            return true;
        }
        if (empty($this->estimate_start_date_project) || empty($this->estimate_end_date_project)
            || empty($this->start_date_process) || empty($this->end_date_process)) {
            return false;
        }
        $manPower = $value;

        $available_processes = $this->projectService->getProcessbetweenDate(
            $this->employee_id,
            $this->start_date_process,
            $this->end_date_process,
            $this->except_project_id
        )->get();

        $totalManPower = $manPower + getTotalManPowerofProcesses($available_processes);
        if ($totalManPower > 1) {
            $employee = !is_null(Employee::find($this->employee_id)) ?
                Employee::find($this->employee_id)->name : '';
            $this->message = "Total man power of member " . $employee .
                "(id = " . $this->employee_id . ') = ' . $totalManPower . ' is over 1';
            request()->request->add(['available_processes' => $available_processes->toArray()]);
            return false;
        } else {
            return true;
        }
    }

    public function message()
    {
        return $this->message;
    }
}