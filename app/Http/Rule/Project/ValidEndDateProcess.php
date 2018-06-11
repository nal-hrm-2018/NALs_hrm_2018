<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 5/8/2018
 * Time: 3:01 PM
 */

namespace App\Http\Rule\Project;

use App\Models\Process;
use App\Models\Project;
use App\Service\ProjectService;
use Illuminate\Contracts\Validation\Rule;
use Carbon\Carbon;

class ValidEndDateProcess implements Rule
{
    private $real_start_date_project;
    private $real_end_date_project;
    private $estimate_start_date_project;
    private $estimate_end_date_project;
    private $start_date_process;
    private $message;
    private $projectService;
    private $delete_flag;
    private $project_id;
    public function __construct(
        $estimate_start_date_project,
        $estimate_end_date_project,
        $real_start_date_project,
        $real_end_date_project,
        $start_date_process,
        $delete_flag,
        $project_id
    )
    {
        $array_param = func_get_args();
        $this->projectService = app(ProjectService::class);
        $this->estimate_start_date_project = $estimate_start_date_project;
        $this->estimate_end_date_project = $estimate_end_date_project;
        $this->real_start_date_project = $real_start_date_project;
        $this->real_end_date_project = $real_end_date_project;
        $this->start_date_process = $start_date_process;
        $this->delete_flag=$delete_flag;
        $this->project_id=$project_id;

    }

    public function passes($attribute, $value)
    {
        if(!is_null($this->delete_flag)&&$this->delete_flag!=='0')
        {
            return true;
        }
        $end_date_process = $value;
        if (empty($this->estimate_start_date_project) || empty($this->estimate_end_date_project)) {
            return false;
        }

        $project = Project::where('delete_flag',0)->find($this->project_id);
        if(!empty($this->project_id)){
            if (!is_null($project)) {
                $end_date_project = $project->end_date;
                if (!empty($end_date_project)) {
                    $this->message = 'Cant add process because The end date project has defined at ' . date('d/m/Y', strtotime($end_date_project));
                    return false;
                }
            } else {
                $this->message = "Project Id not correct ";
                return false;
            }
        }
        $end_date_process = Carbon::parse($end_date_process);
        $start_date_process = Carbon::parse($this->start_date_process);
        if (!empty($this->real_start_date_project)) {
            $real_start_date_project = Carbon::parse($this->real_start_date_project);
            if (!empty($this->real_end_date_project)) {
                $real_end_date_project = Carbon::parse($this->real_end_date_project);
                // real_start && real end nn
                if ($start_date_process->gte($real_start_date_project) && $end_date_process->lte($real_end_date_project)) {
                    return true;
                } else {
                    $this->message = "The start date process and end date process must be between real start date project and real end date project.";
                    return false;
                }
            } else {
                //real_start && est_end
                $estimate_end_date_project = Carbon::parse($this->estimate_end_date_project);
                if ($start_date_process->gte($real_start_date_project) && $end_date_process->lte($estimate_end_date_project)) {
                    return true;
                } else {
                    $this->message = "The start date process and end date process must be between real start date project and estimate end date project.";
                    return false;
                }
            }
        } else {
            // real_start = null , real_end != null
            if (!empty($this->real_end_date_project)) {
                return false;
            } else {
                //est && est
                $estimate_end_date_project = Carbon::parse($this->estimate_end_date_project);
                $estimate_start_date_project = Carbon::parse($this->estimate_start_date_project);
                if ($start_date_process->gte($estimate_start_date_project) && $end_date_process->lte($estimate_end_date_project)) {
                    return true;
                } else {
                    $this->message = "The start date process and end date process must be between estimate start date project and estimate end date project.";
                    return false;
                }
            }
        }
    }

    public function message()
    {
        return $this->message;
    }
}