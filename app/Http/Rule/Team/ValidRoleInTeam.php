<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 5/8/2018
 * Time: 3:01 PM
 */

namespace App\Http\Rule\Team;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\Role;
class ValidRoleInTeam implements Rule
{
    private $msg;
    public function __construct()
    {

    }

    public function passes($attribute, $value)
    {
        // check dup id po vs member
        $this->msg = "";
        $id_po = Role::select('id')->where('name','=','PO')->first();
        if($value != null){
            foreach ($value as $objMember){
                if( (int)$objMember['role'] == $id_po->id){
                    $this->msg .= "Member id = ".$objMember['id']." role other PO";
                }
            }
        }
        if($this->msg != ""){
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
