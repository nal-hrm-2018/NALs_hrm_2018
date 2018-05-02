<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 4/11/2018
 * Time: 7:48 AM
 */

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class TeamRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'description' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => trans('validation.required', [
                'attribute' => 'Team Name'
            ]),
            'description.required' => trans('validation.required', [
                'attribute' => 'description'
            ])
        ];
    }
}