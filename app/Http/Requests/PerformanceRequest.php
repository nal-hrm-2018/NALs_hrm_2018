<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 4/11/2018
 * Time: 7:55 AM
 */

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class PerformanceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required',
            'point' => 'required|numeric|between:0,10',
            'strong' => 'required',
            'weak' => 'required',
            'suggest' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => trans('validation.required', [
                'attribute' => 'Title'
            ]),
            'point.required' => trans('validation.required', [
                'attribute' => 'Point'
            ]),
            'point.numeric' => trans('validation.numeric', [
                'attribute' => 'Point'
            ]),
            'point.between' => trans('validation.between.numeric', [
                'attribute' => 'Point',
                'min' => '0',
                'max' => '10'
            ]),
            'strong.required' => trans('validation.required', [
                'attribute' => 'Strong'
            ]),
            'weak.required' => trans('validation.required', [
                'attribute' => 'Weak'
            ]),
            'suggest.required' => trans('validation.required', [
                'attribute' => 'Suggest'
            ])
        ];
    }
}