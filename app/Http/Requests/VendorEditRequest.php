<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 4/11/2018
 * Time: 7:34 AM
 */

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use App\Http\Rule\ValidEmail;
class VendorEditRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => [ 
                'required',
                'email',
                new ValidEmail(request()->get('email'), request()->route()->parameters())],
            'confirm_confirmation' => 'same:password',
            'name' => 'required',
            'address' => 'required',
            'gender' => [
                'required',
                'integer',
                'digits_between:1,3',
            ],
            'mobile' => 'required|numeric|digits_between:10,11',
            'marital_status' =>  [
                'required',
                'integer',
                'digits_between:1,4',
            ],
            'company' => 'required',
            'role_id' => 'required',
            'birthday' => 'required|before:today',
            'startwork_date' => 'required',
            'endwork_date' => 'required|after:startwork_date'
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
            
            'password.min' => trans('validation.min.string', [
                'attribute' => 'Password',
                'min' => '6'
            ]),
            'confirm_confirmation.same' => trans('validation.same', [
                'attribute' => 'confirm password'
            ]),
            'name.required' => trans('validation.required', [
                'attribute' => 'Name'
            ]),
            'address.required' => trans('validation.required', [
                'attribute' => 'Address'
            ]),
            'gender.required' => trans('validation.required', [
                'attribute' => 'Gender'
            ]),
            'gender.integer' => trans('validation.not_in', [
                'attribute' => 'Gender'
            ]),
            'gender.digits_between' => trans('validation.not_in', [
                'attribute' => 'Gender'
            ]),
            'mobile.required' => trans('validation.required', [
                'attribute' => 'Mobile'
            ]),
            'mobile.numeric' => trans('validation.numeric', [
                'attribute' => 'Mobile'
            ]),
            'mobile.digits_between' => trans('validation.digits_between', [
                'attribute' => 'Mobile',
                'min' => '10',
                'max' => '11'
            ]),
            'marital_status.required' => trans('validation.required', [
                'attribute' => 'Married'
            ]),
            'marital_status.integer' => trans('validation.not_in', [
                'attribute' => 'Married'
            ]),
            'marital_status.digits_between' => trans('validation.not_in', [
                'attribute' => 'Married'
            ]),
            'company.required' => trans('validation.required', [
                'attribute' => 'Company'
            ]),
            /*'curriculum_vitae.required' => trans('validation.required', [
                'attribute' => 'CV'
            ]),*/
            'role_id.required' => trans('validation.required', [
                'attribute' => 'Role'
            ]),
            /*'avatar.required' => trans('validation.required', [
                'attribute' => 'Avatar'
            ]),*/
            'birthday.required' => trans('validation.required', [
                'attribute' => 'Birthday'
            ]),
            'birthday.before' => trans('validation.before', [
                'attribute' => 'Birthday',
                'date' => 'Today'
            ]),
            'startwork_date.required' => trans('validation.required', [
                'attribute' => 'Start Work Date'
            ]),
            'endwork_date.required' => trans('validation.required', [
                'attribute' => 'End Work Date'
            ]),
            'endwork_date.date_format' => trans('validation.date_format', [
                'attribute' => 'End Work Date',
                'format' => 'dd-mm-YYYY'
            ]),
        ];
    }
}