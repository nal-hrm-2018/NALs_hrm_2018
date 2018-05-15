<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 4/11/2018
 * Time: 7:34 AM
 */

namespace App\Http\Requests;

class VendorAddRequest extends CommonRequest
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
                'unique:employees,email'
            ],
            'password' => 'required|min:6',
            'confirm_confirmation' => 'required|same:password',
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
            /*'curriculum_vitae' => 'required',*/
            'employee_type_id' => 'required',
            'role_id' => 'required',
            'company'=> [
                'required',
                'regex:/(^[a-zA-Z0-9 ]+$)+/',
                ],
            /*'avatar' => 'required',*/
            'birthday' =>[
                'required',
                'before:today',
                'date_format:"Y-m-d"'
            ],
            'startwork_date' =>[
                'required',
                'date_format:"Y-m-d"'
            ],
            'endwork_date' => [
                'required',
                'date_format:"Y-m-d"',
                'after:startwork_date'
            ]
        ];
    }

    public function messages()
    {
        return [
            'company.required' => trans('validation.required', [
                'attribute' => 'Company'
            ]),
            'company.regex' => trans('validation.regex', [
                'attribute' => 'Company'
            ]),
            'email.required' => trans('validation.required', [
                'attribute' => 'Email'
            ]),
            'email.email' => trans('validation.email', [
                'attribute' => 'Email'
            ]),
            'email.unique' => trans('validation.unique', [
                'attribute' => 'Email'
            ]),
            'password.required' => trans('validation.required', [
                'attribute' => 'Password'
            ]),
            'password.min' => trans('validation.min.string', [
                'attribute' => 'Password',
                'min' => '6'
            ]),
            'confirm_confirmation.required' => trans('validation.required', [
                'attribute' => 'confirm password'
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
            /*'curriculum_vitae.required' => trans('validation.required', [
                'attribute' => 'CV'
            ]),*/
            'employee_type_id.required' => trans('validation.required', [
                'attribute' => 'Position'
            ]),
            'role_id.required' => trans('validation.required', [
                'attribute' => 'Role'
            ]),
            /*'avatar.required' => trans('validation.required', [
                'attribute' => 'Avatar'
            ]),*/
            'birthday.required' => trans('validation.required', [
                'attribute' => 'Birthday'
            ]),
            'birthday.date_format' => trans('validation.date_format', [
                'attribute' => 'Birthday',
                'format' => 'dd-mm-YYYY'
            ]),
            'birthday.before' => trans('validation.before', [
                'attribute' => 'Birthday',
                'date' => 'Today'
            ]),
            'startwork_date.required' => trans('validation.required', [
                'attribute' => 'Start Work Date'
            ]),
            'startwork_date.date_format' => trans('validation.date_format', [
                'attribute' => 'Start Work Date',
                'format' => 'dd-mm-YYYY'
            ]),
            'endwork_date.required' => trans('validation.required', [
                'attribute' => 'End Work Date'
            ]),
            'endwork_date.date_format' => trans('validation.date_format', [
                'attribute' => 'End Work Date',
                'format' => 'dd-mm-YYYY'
            ]),
            'endwork_date.after' => trans('validation.after', [
                'attribute' => 'End Work Date',
                'date'=>'Start Work Date'
            ]),
        ];
    }
}