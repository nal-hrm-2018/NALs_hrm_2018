<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 4/16/2018
 * Time: 2:16 PM
 */

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|email|max:255',
            'password' => 'required|min:6',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => trans('validation.required', [
                'attribute' => 'email'
            ]),
            'email.email' => trans('validation.email', [
                'attribute' => 'email'
            ]),
            'email.max' => trans('validation.max.string', [
                'attribute' => 'email',
                'max' => '255'
            ]),
            'password.required' => trans('validation.required', [
                'attribute' => 'password'
            ]),
            'password.min' => trans('validation.min.string', [
                'attribute' => 'password',
                'min' => '6'
            ]),
        ];
    }
}