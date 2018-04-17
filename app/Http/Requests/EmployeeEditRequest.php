<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 4/11/2018
 * Time: 7:34 AM
 */

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class EmployeeEditRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|email',
            'name' => 'required',
            'address' => 'required',
            'gender' => 'required',
            'mobile' => 'required|numeric|digits_between:10,11',
            'marital_status' => 'required',
            /*'curriculum_vitae' => 'required',*/
            'teams_id' => 'required',
            'company' => 'required',
            /*'avatar' => 'required',*/
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
            /*'curriculum_vitae.required' => trans('validation.required', [
                'attribute' => 'CV'
            ]),*/
            'teams_id.required' => trans('validation.required', [
                'attribute' => 'Team'
            ]),
            'company.required' => trans('validation.required', [
                'attribute' => 'Company'
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