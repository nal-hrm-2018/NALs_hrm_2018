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
use App\Http\Rule\Project\ValidAtLeastOnePo;
class ProjectEditRequest extends CommonRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        session()->flash('processes',request()->get('processes'));
        return
            [
                'name' => 'required',
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
                        'after_or_equal:estimate_start_date'
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
                       new ValidEndDateProject(request()->get('start_date_project')),
                       'after_or_equal:start_date_project',
                    ],

                'processes'=>[
                    'required',
                    new ValidAtLeastOnePo(request()->get('processes'))
                ]
                ,
                'income' =>
                    [
                        'bail',
                        'required',
                        'numeric',
                        'min:0'
                    ],
                'real_cost' =>
                    [
                        'bail',
                        'nullable',
                        'numeric',
                        'min:0',
                    ],
                'status' => [
                    'bail',
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
            'processes.required' => trans('validation.custom.role.at_least_one_po'),

            'name.required' => trans('validation.required', [
                'attribute' => trans('project.project_name')
            ]),

            'income.required' => trans('validation.required', [
                'attribute' => trans('project.income')
            ]),
            'income.numeric' => trans('validation.numeric', [
                'attribute' => trans('project.income')
            ]),
            'income.min' => trans('validation.min', [
                'attribute' => trans('project.income')
            ]),

            'real_cost.min' => trans('validation.min', [
                'attribute' => trans('project.real_cost')
            ]),
            'real_cost.numeric' => trans('validation.numeric', [
                'attribute' => trans('project.real_cost')
            ]),
            'status.required' => trans('validation.required', [
                'attribute' => trans('project.status')
            ]),

            'start_date_project.before_or_equal'=>trans('validation.before_or_equal',[
                'attribute' => trans('project.start_date_real'),
                'date' => trans('project.estimate_end_date'),
            ]),

            'end_date_project.after_or_equal' => trans('validation.after_or_equal', [
                'attribute' => trans('project.end_date_real'),
                'date' => trans('project.start_date_real'),
            ]),

            'estimate_start_date.required' => trans('validation.required', [
                'attribute' => trans('project.estimate_start_date'),
            ]),

            'estimate_end_date.required' => trans('validation.required', [
                'attribute' => trans('project.estimate_end_date'),
            ]),
            'estimate_end_date.after_or_equal' => trans('validation.after_or_equal', [
                'attribute' => trans('project.estimate_end_date'),
                'date' => trans('project.estimate_start_date'),
            ]),
        ];
    }
}