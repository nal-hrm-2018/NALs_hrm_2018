<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 5/8/2018
 * Time: 3:01 PM
 */

namespace App\Http\Rule;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\Team;
class ValidAbsenceFilter implements Rule
{
    private $year;
    private $msg;
    public function __construct($year)
    {
        $this->year = $year;
    }

    public function passes($attribute, $value)
    {
        if(empty($this->year)&&!empty($value)){
            $this->msg = trans('absence.msg_content.msg_filter_invalid');
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
        return $this->msg;
    }
}