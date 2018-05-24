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

class ProcessAddRequest extends CommonRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id' =>
                [
                    'required',
                    'exists:employees,id'
                ],
            'start_date_project' =>
                [
                    'nullable',
                    'after_or_equal:today',
                ],
            'end_date_project' =>
                [
                    'nullable',
                    'after_or_equal:start_date_project',
                    new ValidEndDateProject(request()->get('start_date_project')),
                    'before_or_equal:today',
                ],

            'estimate_start_date' =>
                [
                    'required',
                    'after_or_equal:today',
                ],
            'estimate_end_date' =>
                [
                    'required',
                    'after_or_equal:estimate_start_date'
                ],
            'start_date_process' =>
                [
                    'required',
                    'after_or_equal:today',
                ],
            'end_date_process' =>
                [
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
                    'required',
                    new ValidManPower(request()->get('start_date_process'), request()->get('end_date_process'))
                ],
            'role' =>
                [
                    'required',
                    'exists:roles,id'
                ]
        ];
    }

    public function messages()
    {
        return [
        ];
    }
}