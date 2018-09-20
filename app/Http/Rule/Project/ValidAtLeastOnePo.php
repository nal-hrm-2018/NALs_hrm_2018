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
class ValidAtLeastOnePo implements Rule
{
    private $message;
    private $processes;
    public function __construct($processes)
    {
        $this->processes=$processes;
    }

    public function passes($attribute, $value)
    {
        //kiem tra processes phai co it nhat 1 po
        if (!checkPOinProject($this->processes)) {
            $this->message = trans('validation.custom.role.at_least_one_po');
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