<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 4/11/2018
 * Time: 7:34 AM
 */

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required|min:6',
            'name' => 'required',
            'address' => 'required',
            'gender' => 'required',
            'mobile' => 'required|numeric|digits_between:10,11',
            'marital_status' => 'required',
            'curriculum_vitae' => 'required',
            'team' => 'required',
            'company' => 'required',
            'avatar' => 'required',
            'birthday' => 'required|date_format:"d-m-Y"|before:today',
            'start_work_date' => 'required|date_format:"d-m-Y"',
            'end_work_date' => 'required|date_format:"d-m-Y"|after:start_work_date'
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
            'password.required' => trans('validation.required', [
                'attribute' => 'Password'
            ]),
            'password.min' => trans('validation.min.string', [
                'attribute' => 'Password',
                'min' => '6'
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
            'curriculum_vitae.required' => trans('validation.required', [
                'attribute' => 'CV'
            ]),
            'team.required' => trans('validation.required', [
                'attribute' => 'Team'
            ]),
            'company.required' => trans('validation.required', [
                'attribute' => 'Company'
            ]),
            'avatar.required' => trans('validation.required', [
                'attribute' => 'Avatar'
            ]),
            'birthday.required' => trans('validation.required', [
                'attribute' => 'Birthday'
            ]),
            'birthday.date_format' => trans('validation.date_format', [
                'attribute' => 'Birthday',
                'format' => 'd-m-Y'
            ]),
            'birthday.before' => trans('validation.before', [
                'attribute' => 'Birthday',
                'date' => 'Today'
            ]),
            'start_work_date.required' => trans('validation.required', [
                'attribute' => 'Start Work Date'
            ]),
            'start_work_date.date_format' => trans('validation.date_format', [
                'attribute' => 'Start Work Date',
                'format' => 'd-m-Y'
            ]),
            'end_work_date.required' => trans('validation.required', [
                'attribute' => 'End Work Date'
            ]),
            'end_work_date.date_format' => trans('validation.date_format', [
                'attribute' => 'End Work Date',
                'format' => 'd-m-Y'
            ]),
            'end_work_date.after' => trans('validation.before', [
                'attribute' => 'End Work Date',
                'date' => 'Start Work Date'
            ])
        ];
    }
}