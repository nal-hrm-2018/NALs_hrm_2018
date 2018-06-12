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
class ValidDupeMember implements Rule
{
    public function __construct()
    {
    }

    public function passes($attribute, $value)
    {
        // check member duplication
        $listIdMember = array();
        if($value != null){
            $i = 0;
            foreach ($value as $objMember){
                $listIdMember[$i] = $objMember['id'];
                $i++;
            }
            
        }
        if (array_has_dupes($listIdMember)){
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
        return trans('Member not duplicate !!!');
    }
}