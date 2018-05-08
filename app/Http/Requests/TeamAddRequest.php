<?php
/**
 * Created by PhpStorm.
<<<<<<< 8d479ff14ab6177582459bec85a0b7f93e79283e
 * User: Ngoc Quy
 * Date: 5/7/2018
 * Time: 2:01 PM
=======
 * User: Alex
 * Date: 5/7/2018
 * Time: 1:37 PM
>>>>>>> implement function add new team
 */

namespace App\Http\Requests;


use App\Http\Rule\ValidTeamName;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Rule\ValidDupeMember;
use App\Http\Rule\ValidPoName;

class TeamAddRequest extends FormRequest
{
    public function authorize(){
        return true;
    }
    public function rules(){
        return[
            'team_name' => [
                'required',
                'max:50',
                'regex:/(^[a-zA-Z0-9 ]+$)+/',
                new ValidTeamName()],
            'id_po' => new ValidPoName(request()->get('members')),
            'members' => new ValidDupeMember()
        ];
    }
    public  function messages()
    {
        return [
            'team_name.required' => trans('validation.required', [
                'attribute' => 'Team Name'
            ]),
            'team_name.max' => trans('validation.max.string', [
                'attribute' => 'Team Name'
            ]),
            'team_name.regex' => trans('validation.regex', [
                'attribute' => 'Team Name'
            ]),
        ];
    }


}