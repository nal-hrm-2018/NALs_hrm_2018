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
use Illuminate\Support\Facades\Auth;
class EmployeeEditRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if (Auth::user()->hasRole('HR')){
            return [
                'email' =>[
//                'required',
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
                'mobile' => 'required|numeric|min:1|digits_between:10,11',
                'marital_status' =>  [
                    'required',
                    'integer',
                    'digits_between:1,4',
                ],
                /*'curriculum_vitae' => 'required',*/
//            'employee_type_id' => 'required',
//            'team_id' => 'required',
//            'role_id' => 'required',
                /*'avatar' => 'required',*/
                'birthday' => 'required|before:today|after:1900-01-01',
                'picture' => 'image|max:2048',
                'startwork_date' => 'required|after:birthday',
            'endwork_date' => 'required|after:startwork_date|after:birthday'
            ];
        }
        return [
            'email' =>[
//                'required',
                'email',
                new ValidEmail(request()->get('email'), request()->route()->parameters())],
            'confirm_confirmation' => 'same:password',
            //'name' => 'required',
            'address' => 'required',
            'gender' => [
                'required',
                'integer',
                'digits_between:1,3',
            ],
            'mobile' => 'required|numeric|min:1|digits_between:10,11',
            'marital_status' =>  [
                'required',
                'integer',
                'digits_between:1,4',
            ],
            /*'curriculum_vitae' => 'required',*/
//            'employee_type_id' => 'required',
//            'team_id' => 'required',
//            'role_id' => 'required',
            /*'avatar' => 'required',*/
            'birthday' => 'required|before:today',
            'picture' => 'image|max:2048',
//          'startwork_date' => 'required|after:birthday',
//            'endwork_date' => 'required|after:startwork_date'
        ];

    }

    public function messages()
    {
        return [
            'email.required' => trans('validation.required', [
                'attribute' => trans('employee.profile_info.email')
            ]),
            'picture.uploaded' => trans('validation.max.file',[
                'attribute' => trans('employee.profile_info.picture'),
                'max' => trans('employee.profile_info.max')
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
            'mobile.min' => trans('validation.bigger_zero', [
                'attribute' => trans('employee.profile_info.phone'),
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
            /*'curriculum_vitae.required' => trans('validation.required', [
                'attribute' => 'CV'
            ]),*/
            'employee_type_id.required' => trans('validation.required', [
                'attribute' => trans('employee.profile_info.position')
            ]),
            'team_id.required' => trans('validation.required', [
                'attribute' => trans('employee.profile_info.team')
            ]),
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
                'date' => trans('employee.profile_info.today')
            ]),
            'birthday.after' => trans('validation.after', [
                'attribute' => trans('employee.profile_info.birthday'),
                'date' => '01-01-1900'
            ]),
            'startwork_date.required' => trans('validation.required', [
                'attribute' => trans('employee.profile_info.start_work')
            ]),
            'startwork_date.after' => trans('validation.after', [
                'attribute' => trans('employee.profile_info.start_work'),
                'date' => trans('employee.profile_info.birthday')
            ]),
            'endwork_date.required' => trans('validation.required', [
                'attribute' => trans('employee.profile_info.end_work')
            ]),
//            'endwork_date.after_b' => trans('validation.after', [
//                'attribute' => trans('employee.profile_info.end_work'),
//                'date' => trans('employee.profile_info.birthday'),
//            ]),
            'endwork_date.after' => trans('validation.after', [
                'attribute' => trans('employee.profile_info.end_work'),
                'date' => trans('employee.profile_info.start_work')
            ]),
            'endwork_date.date_format' => trans('validation.date_format', [
                'attribute' => trans('employee.profile_info.end_work'),
                'format' => 'dd-mm-YYYY'
            ]),
        ];
    }
}