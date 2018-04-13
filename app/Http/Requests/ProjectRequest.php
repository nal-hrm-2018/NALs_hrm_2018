<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 4/11/2018
 * Time: 7:50 AM
 */

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id' => 'required',
            'name' => 'required',
            'income' => 'required|numeric',
            'real_cost' => 'required|numeric',
            'status' => 'required'
        ];
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