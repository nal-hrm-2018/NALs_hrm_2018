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

class ValidManPower implements Rule
{
    private $start_date_process;
    private $end_date_process;
    private $message;
    private $projectService;

    public function __construct($start_date_process, $end_date_process)
    {
        $this->projectService = app(ProjectService::class);
        $this->start_date_process = $start_date_process;
        $this->end_date_process = $end_date_process;
    }

    public function passes($attribute, $value)
    {
        $manPower = $value;
        if (empty($this->start_date_process) || empty($this->end_date_process || is_null($manPower))) {
            return false;
        } else {
            $available_processes = $this->projectService->getProcessbetweenDate(
                request()->get('id'),
                $this->start_date_process,
                $this->end_date_process
            )->get();

            $totalManPower = $manPower + getTotalManPowerofProcesses($available_processes);
            if ($totalManPower > 1) {
                $this->message = "Total man power of member id " . request()->get('id').' = '.$totalManPower.' is over 1';
                session()->push('available_processes', $available_processes->toArray());
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