<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 4/13/2018
 * Time: 9:53 AM
 */

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class AuthorizationRequest extends FormRequest
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
            'password_confirmation' => 'required|same:password',
            'confirmation_code' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => trans('validation.required', [
                'attribute' => 'Email'
            ]),
            'email.email' => trans('validation.email', [
                'attribute' => 'Email'
            ]),
            'email.max' => trans('validation.max.string', [
                'attribute' => 'Email',
                'max' => '255'
            ]),
            'password.required' => trans('validation.required', [
                'attribute' => 'Password'
            ]),
            'password.min' => trans('validation.min.string', [
                'attribute' => 'Password',
                'min' => '6'
            ]),
            'password_confirmation.required' => trans('validation.required', [
                'attribute' => 'Password Confirmation'
            ]),
            'password_confirmation.same' => trans('validation.same', [
                'attribute' => 'Password Confirmation',
                'other' => 'Password'
            ]),
            'confirmation_code.required' => trans('validation.required', [
                'attribute' => 'Confirmation Code'
            ]),
        ];
    }
}