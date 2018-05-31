<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 4/11/2018
 * Time: 7:50 AM
 */

namespace App\Http\Requests;

use App\Http\Rule\Project\ValidEndDateProject;
use App\Http\Rule\Project\ValidEndDateProcess;
use App\Http\Rule\Project\ValidManPower;
use App\Http\Rule\Project\ValidMember;
use App\Http\Rule\Project\ValidRoleProject;
use App\Http\Rule\Project\ValidDupeMember;

class ProcessAddRequest extends CommonRequest
{
    public function authorize()
    {
        return true;
    }

    public function ruleReValidate(
        $estimate_start_date,
        $estimate_end_date,
        $start_date_project,
        $end_date_project,
        $start_date_process,
        $end_date_process
    )
    {

        return [
            'employee_id' =>
                [
                    'bail',
                    'required',
                    new ValidMember(),
//                    new ValidDupeMember(request()->get('processes')),
                ],
            'start_date_process' =>
                [
                    'bail',
                    'required',
                ],
            'end_date_process' =>
                [
                    'bail',
                    'required',
                    'after_or_equal:start_date_process',
                    new ValidEndDateProcess(
                        $estimate_start_date,
                        $estimate_end_date,
                        $start_date_project,
                        $end_date_project,
                        $start_date_process
                    ),
                ],
            'man_power' =>
                [
                    'bail',
                    'required',
                    new ValidManPower(
                        $start_date_process,
                        $end_date_process,
                        $estimate_start_date,
                        $estimate_end_date
                    )
                ],
            'role_id' =>
                [
                    'bail',
                    'required',
                    'exists:roles,id',
//                    new ValidRoleProject(request()->get('processes')),
                ]
        ];
    }

    public function rules()
    {
        return [
            'employee_id' =>
                [
                    'bail',
                    'required',
                    new ValidMember(),
//                    new ValidDupeMember(request()->get('processes')),
                ],
            'start_date_project' =>
                [
                    'bail',
                    'nullable',
                    'before_or_equal:estimate_end_date',
                ],
            'end_date_project' =>
                [
                    'bail',
                    'nullable',
                    'after_or_equal:start_date_project',
                    new ValidEndDateProject(request()->get('start_date_project')),
                ],

            'estimate_start_date' =>
                [
                    'bail',
                    'required',
                ],
            'estimate_end_date' =>
                [
                    'bail',
                    'required',
                    'after_or_equal:estimate_start_date',
                ],
            'start_date_process' =>
                [
                    'bail',
                    'required',
                ],
            'end_date_process' =>
                [
                    'bail',
                    'required',
                    'after_or_equal:start_date_process',
                    new ValidEndDateProcess(
                        request()->get('estimate_start_date'),
                        request()->get('estimate_end_date'),
                        request()->get('start_date_project'),
                        request()->get('end_date_project'),
                        request()->get('start_date_process')
                    ),
                ],
            'man_power' =>
                [
                    'bail',
                    'required',
                    new ValidManPower(
                        request()->get('start_date_process'),
                        request()->get('end_date_process'),
                        request()->get('estimate_start_date'),
                        request()->get('estimate_end_date')
                    )
                ],
            'role_id' =>
                [
                    'bail',
                    'required',
                    'exists:roles,id',
//                    new ValidRoleProject(request()->get('processes')),
                ]
        ];
    }

    public function messages()
    {
        return [
        ];
    }
}