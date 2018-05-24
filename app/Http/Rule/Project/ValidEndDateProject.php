<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 5/8/2018
 * Time: 3:01 PM
 */

namespace App\Http\Rule\Project;

use Illuminate\Contracts\Validation\Rule;
use Carbon\Carbon;

class ValidEndDateProject implements Rule
{
    private $message;
    private $real_start_date;

    public function __construct($real_start_date)
    {
        $this->real_start_date = $real_start_date;
    }

    public function passes($attribute, $value)
    {
        if (empty($this->real_start_date) && !empty($value)) {
            $this->message = "The real start date is null , real end day can't be not null .";
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