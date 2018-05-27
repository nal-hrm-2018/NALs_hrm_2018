<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 4/11/2018
 * Time: 7:50 AM
 */

namespace App\Http\Requests;

use App\Http\Rule\Project\ValidEndDateProject;
use App\Http\Rule\Project\ValidStatusProject;

class ProjectAddRequest extends CommonRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return
            [
                'id' =>
                    [
                        'required',
                        'unique:projects,id'
                    ],
                'name' => 'required',
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
                'income' =>
                    [
                        'required',
                        'numeric',
                        'min:0'
                    ],
                'real_cost' =>
                    [
                        'nullable',
                        'numeric',
                        'min:0',
                    ],
                'status' => [
                    'required',
                    new ValidStatusProject(
                        request()->get('start_date_project'),
                        request()->get('end_date_project'),
                        request()->get('estimate_start_date'),
                        request()->get('estimate_end_date')
                    ),
                ],
            ];
    }

    public function messages()
    {
        return [
            'id.required' => trans('validation.required', [
                'attribute' => 'Project Id'
            ]),
            'id.unique' => trans('validation.unique', [
                'attribute' => 'Project Id'
            ]),

            'name.required' => trans('validation.required', [
                'attribute' => 'Project Name'
            ]),

            'income.required' => trans('validation.required', [
                'attribute' => 'Income'
            ]),
            'income.numeric' => trans('validation.numeric', [
                'attribute' => 'Income'
            ]),
            'income.min' => trans('validation.min', [
                'attribute' => 'Income'
            ]),

            'real_cost.min' => trans('validation.min', [
                'attribute' => 'Real Cost'
            ]),
            'real_cost.numeric' => trans('validation.numeric', [
                'attribute' => 'Real Cost'
            ]),
            'status.required' => trans('validation.required', [
                'attribute' => 'Status'
            ]),

            'start_date_project.after_or_equal' => trans('validation.after_or_equal', [
                'attribute' => 'Start Date Project',
                'date' => 'to day'
            ]),

            'end_date_project.after_or_equal' => trans('validation.after_or_equal', [
                'attribute' => 'End Date Project',
                'date' => 'Start Date Project'
            ]),

            'end_date_project.before_or_equal' => trans('validation.before_or_equal', [
                'attribute' => 'End Date Project',
                'date' => 'to day'
            ]),

            'estimate_start_date.required' => trans('validation.required', [
                'attribute' => 'Estimate Start Date',
            ]),
            'estimate_start_date.after_or_equal' => trans('validation.after_or_equal', [
                'attribute' => 'Estimate Start Date',
                'date' => 'to day'
            ]),

            'estimate_end_date.required' => trans('validation.required', [
                'attribute' => 'Estimate End Date'
            ]),
            'estimate_end_date.after_or_equal' => trans('validation.after_or_equal', [
                'attribute' => 'Estimate End Date',
                'date' => 'Estimate Start Date'
            ]),
        ];
    }
}