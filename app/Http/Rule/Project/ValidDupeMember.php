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
class ValidDupeMember implements Rule
{
    private $message;
    private $processes;
    public function __construct($processes)
    {
        $this->processes=$processes;
    }

    public function passes($attribute, $value)
    {
        // check member duplication
        $employee_id = $value;
        $this->processes[]=['employee_id'=>$employee_id];
        if(hasDupeProject($this->processes,'employee_id')){
            $this->message = "Member in process can't duplicate .";
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