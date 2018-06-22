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
            'marital_status' => [
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
                'attribute' => trans('employee.profile_info.email')
            ]),
            'email.email' => trans('validation.email', [
                'attribute' => trans('employee.profile_info.email')
            ]),
            
            'password.min' => trans('validation.min.string', [
                'attribute' => trans('employee.profile_info.password'),
                'min' => '6'
            ]),
            'confirm_confirmation.same' => trans('validation.same', [
                'attribute' => trans('employee.profile_info.password_confirm')
            ]),
            'name.required' => trans('validation.required', [
                'attribute' => trans('employee.profile_info.name')
            ]),
            'address.required' => trans('validation.required', [
                'attribute' => trans('employee.profile_info.address')
            ]),
            'gender.required' => trans('validation.required', [
                'attribute' => trans('employee.profile_info.gender.title')
            ]),
            'gender.integer' => trans('validation.not_in', [
                'attribute' => trans('employee.profile_info.gender.title')
            ]),
            'gender.digits_between' => trans('validation.not_in', [
                'attribute' => trans('employee.profile_info.gender.title')
            ]),
            'mobile.required' => trans('validation.required', [
                'attribute' => trans('employee.profile_info.phone')
            ]),
            'mobile.numeric' => trans('validation.numeric', [
                'attribute' => trans('employee.profile_info.phone')
            ]),
            'mobile.digits_between' => trans('validation.digits_between', [
                'attribute' => trans('employee.profile_info.phone'),
                'min' => '10',
                'max' => '11'
            ]),
            'marital_status.required' => trans('validation.required', [
                'attribute' => trans('employee.profile_info.marital_status.title')
            ]),
            'marital_status.integer' => trans('validation.not_in', [
                'attribute' => trans('employee.profile_info.marital_status.title')
            ]),
            'marital_status.digits_between' => trans('validation.not_in', [
                'attribute' => trans('employee.profile_info.marital_status.title')
            ]),
            'company.required' => trans('validation.required', [
                'attribute' => trans('vendor.profile_info.company')
            ]),
            /*'curriculum_vitae.required' => trans('validation.required', [
                'attribute' => 'CV'
            ]),*/
            'role_id.required' => trans('validation.required', [
                'attribute' => trans('employee.profile_info.role')
            ]),
            /*'avatar.required' => trans('validation.required', [
                'attribute' => 'Avatar'
            ]),*/
            'birthday.required' => trans('validation.required', [
                'attribute' => trans('employee.profile_info.birthday')
            ]),
            'birthday.before' => trans('validation.before', [
                'attribute' => trans('employee.profile_info.birthday'),
                'date' => 'Today'
            ]),
            'startwork_date.required' => trans('validation.required', [
                'attribute' => trans('employee.profile_info.start_work')
            ]),
            'endwork_date.required' => trans('validation.required', [
                'attribute' => trans('employee.profile_info.end_work')
            ]),
            'endwork_date.date_format' => trans('validation.date_format', [
                'attribute' => trans('employee.profile_info.end_work'),
                'format' => 'dd-mm-YYYY'
            ]),
        ];
    }
}