<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 4/11/2018
 * Time: 7:50 AM
 */

namespace App\Http\Requests;

class ProjectAddRequest extends CommonRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id_project' =>
                [
                    'required',
                    'unique:projects,id'
                ],
            'name_project' => 'required',
            'start_date' => [],
            'end_date' => [],
            'estimate_start_date' => [],
            'estimate_end_date' => [],
            'income' => 'required|numeric',
            'real_cost' => 'required|numeric',
            'description' => '',
            'status' => 'required'];
    }

    public function messages()
    {
        return [
            'id.required' => trans('validation.required', [
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
            'real_cost.required' => trans('validation.required', [
                'attribute' => 'Real Cost'
            ]),
            'real_cost.numeric' => trans('validation.numeric', [
                'attribute' => 'Real Cost'
            ]),
            'status.required' => trans('validation.required', [
                'attribute' => 'Status'
            ])
        ];
    }
}