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
use App\Models\Employee;
class ValidEmail implements Rule
{
    private $email;
    private $id;
    public function __construct($email, $id)
    {
        $this->email = $email;
        $this->id = $id;
    }

    public function passes($attribute, $value)
    {
        $email = Employee::select('email')->where('email', 'like', $this->email)->where('id', '<>', $this->id)->get();
        //check team name already in database
        if ($email -> isEmpty()) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('The Email has already been taken.');
    }
}