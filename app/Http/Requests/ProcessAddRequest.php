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
        $project_id,
        $process,
        $processes
    )
    {
        return [
            'employee_id' =>
                [
                    'bail',
                    'required',
                    new ValidMember(),
                    new ValidDupeMember(
                        $processes,
                        $process['start_date_process'],
                        $process['end_date_process'],
                        $process['delete_flag']
                    ),
                ],
            'man_power' =>
                [
                    'bail',
                    'required',
                ],
            'role_id' =>
                [
                    'bail',
                    'required',
                    'exists:roles,id',
                    new ValidRoleProject(
                        $processes,
                        $process['start_date_process'],
                        $process['end_date_process'],
                        $process['delete_flag'],
                        $process['employee_id']
                    ),
                ],
            'start_date_process' =>
                [
                    'bail',
                    'required',
                    'date_format:Y-m-d',
                ],
            'end_date_process' =>
                [
                    'bail',
                    'required',
                    'date_format:Y-m-d',
                    'after_or_equal:start_date_process',
                    new ValidEndDateProcess(
                        $estimate_start_date,
                        $estimate_end_date,
                        $start_date_project,
                        $end_date_project,
                        $process['start_date_process'],
                        $process['delete_flag'],
                        $project_id
                    ),
                    new ValidManPower(
                        $process['start_date_process'],
                        $process['end_date_process'],
                        $estimate_start_date,
                        $estimate_end_date,
                        $project_id,
                        $process['employee_id'],
                        getArrayManPower(),
                        $process['delete_flag'],
                        $process['man_power']
                    )
                ],

            'delete_flag'=>[
                'bail',
                'nullable',
                'integer',
                'digits_between:0,1',
            ]
        ];
    }

    public function rules()
    {
        return [
            'estimate_start_date' =>
                [
                    'bail',
                    'required',
                    'date_format:Y-m-d',
                ],
            'estimate_end_date' =>
                [
                    'bail',
                    'required',
                    'date_format:Y-m-d',
                    'after_or_equal:estimate_start_date',
                ],
            'start_date_project' =>
                [
                    'bail',
                    'nullable',
                    'date_format:Y-m-d',
                    'before_or_equal:estimate_end_date',
                ],
            'end_date_project' =>
                [
                    'bail',
                    'nullable',
                    'date_format:Y-m-d',
                    new ValidEndDateProject(request()->get('start_date_project')),
                    'after_or_equal:start_date_project',
                ],
            'employee_id' =>
                [
                    'bail',
                    'required',
                    new ValidMember(),
                ],
            'man_power' =>
                [
                    'bail',
                    'required',
                ],
            'role_id' =>
                [
                    'bail',
                    'required',
                    'exists:roles,id',
                ],

            'start_date_process' =>
                [
                    'bail',
                    'required',
                    'date_format:Y-m-d',
                ],
            'end_date_process' =>
                [
                    'bail',
                    'required',
                    'date_format:Y-m-d',
                    'after_or_equal:start_date_process',
                    new ValidEndDateProcess(
                        request()->get('estimate_start_date'),
                        request()->get('estimate_end_date'),
                        request()->get('start_date_project'),
                        request()->get('end_date_project'),
                        request()->get('start_date_process'),
                        request()->get('delete_flag'),
                        null
                    ),
                    new ValidManPower(
                        request()->get('start_date_process'),
                        request()->get('end_date_process'),
                        request()->get('estimate_start_date'),
                        request()->get('estimate_end_date'),
                        request()->get('project_id'),
                        request()->get('employee_id'),
                        getArrayManPower(),
                        request()->get('delete_flag'),
                        request()->get('man_power')
                    )
                ]
        ];
    }

    public function messages()
    {
        return [
        ];
    }
}