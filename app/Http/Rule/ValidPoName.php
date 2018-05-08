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
class ValidPoName implements Rule
{
    private $id_members;
    public function __construct($id_members)
    {
        $this->id_members = $id_members;
    }

    public function passes($attribute, $value)
    {
        if (in_array($value, (array)$this->id_members)) {
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
        return trans('team.msg_content.msg_dupe_po_member');
    }
}