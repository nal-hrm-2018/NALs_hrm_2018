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
use App\Models\Status;

class ValidStatusProject implements Rule
{
    private $message;
    private $real_start_date;
    private $real_end_date;
    private $estimate_start_date_project;
    private $estimate_end_date_project;

    public function __construct(
        $real_start_date,
        $real_end_date,
        $estimate_start_date_project,
        $estimate_end_date_project
    )
    {
        $this->real_start_date = $real_start_date;
        $this->real_end_date = $real_end_date;
        $this->estimate_start_date_project = $estimate_start_date_project;
        $this->estimate_end_date_project = $estimate_end_date_project;
    }

    public function passes($attribute, $value)
    {
        if (empty($this->estimate_start_date_project) && empty($this->estimate_end_date_project)) {
            return false;
        }
        $status = $value;
        $planing = null;
        $complete=null;
        if(!is_null(Status::where('name', '=', config('settings.project_status.planing'))->first())){
            $planing = (string)Status::where('name', '=', config('settings.project_status.planing'))->first()->id;
        }else{
            $this->message = "can't find status planing";
            return false;
        }
        if(!is_null(Status::where('name', '=', config('settings.project_status.complete'))->first())){
            $complete = (string)Status::where('name', '=', config('settings.project_status.complete'))->first()->id;
        }
        else{
            $this->message = "can't find status complete";
            return false;
        }
        if (empty($this->real_start_date)) {
            if ($status !== $planing) {
                $this->message = trans('validation.custom.status.must_be_planning');
                return false;
            }
            return true;
        } else {
            if (empty($this->real_end_date)) {
                if ($status === $planing) {
                    $this->message = trans('validation.custom.status.cant_be_planning');
                    return false;
                }
                if ($status === $complete) {
                    $this->message = trans('validation.custom.status.cant_be_complete');
                    return false;
                }
                return true;
            } else {
                if ($status !== $complete) {
                    $this->message = trans('validation.custom.status.must_be_complete');
                    return false;
                }
                return true;
            }
        }

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