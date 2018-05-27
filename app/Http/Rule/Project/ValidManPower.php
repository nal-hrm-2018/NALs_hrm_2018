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

    public function __construct(
        $start_date_process,
        $end_date_process,
        $estimate_start_date_project,
        $estimate_end_date_project
    )
    {
        $this->projectService = app(ProjectService::class);
        $this->start_date_process = $start_date_process;
        $this->end_date_process = $end_date_process;
        $this->estimate_start_date_project = $estimate_start_date_project;
        $this->estimate_end_date_project = $estimate_end_date_project;
    }

    public function passes($attribute, $value)
    {
        if (empty($this->estimate_start_date_project) && empty($this->estimate_end_date_project)) {
            return false;
        }
        $manPower = $value;
        if (empty($this->start_date_process) || empty($this->end_date_process || is_null($manPower))) {
            return false;
        } else {
            $available_processes = $this->projectService->getProcessbetweenDate(
                request()->get('employee_id'),
                $this->start_date_process,
                $this->end_date_process
            )->get();

            $totalManPower = $manPower + getTotalManPowerofProcesses($available_processes);
            if ($totalManPower > 1) {
                $employee = !is_null(Employee::find(request()->get('employee_id'))) ?
                    Employee::find(request()->get('employee_id'))->name : '';
                $this->message = "Total man power of member " . $employee .
                    "(id = " . request()->get('employee_id') . ') = ' . $totalManPower . ' is over 1';
                request()->request->add(['available_processes'=>$available_processes->toArray()]);
                return false;
            } else {
                return true;
            }
        }
    }


    public function message()
    {
        return $this->message;
    }
}