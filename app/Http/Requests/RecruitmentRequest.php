<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 4/11/2018
 * Time: 7:57 AM
 */

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class RecruitmentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'role' => 'required',
            'team' => 'required',
            'number' => 'required|numeric',
            'yearExp' => 'required|numeric',
            'startFrom' => 'required|date_format:"d-m-Y"',
            'endTo' => 'required|date_format:"d-m-Y"|after:startFrom',
            'status' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'role.required' => trans('validation.required', [
                'attribute' => 'Role'
            ]),
            'team.required' => trans('validation.required', [
                'attribute' => 'Team'
            ]),
            'number.required' => trans('validation.required', [
                'attribute' => 'Number'
            ]),
            'number.numeric' => trans('validation.numeric', [
                'attribute' => 'Number'
            ]),
            'yearExp.required' => trans('validation.required', [
                'attribute' => 'Year Experience'
            ]),
            'yearExp.numeric' => trans('validation.numeric', [
                'attribute' => 'Year Experience'
            ]),
            'startFrom.required' => trans('validation.required', [
                'attribute' => 'Start From'
            ]),
            'startFrom.date_format' => trans('validation.date_format', [
                'attribute' => 'Start From',
                'format' => 'd-m-Y'
            ]),
            'endTo.required' => trans('validation.required', [
                'attribute' => 'End To'
            ]),
            'endTo.date_format' => trans('validation.date_format', [
                'attribute' => 'End To',
                'format' => 'd-m-Y'
            ]),
            'endTo.after' => trans('validation.after', [
                'attribute' => 'End To',
                'date' => 'Start From'
            ]),
            'status.required' => trans('validation.required', [
                'attribute' => 'Status'
            ])
        ];
    }
}