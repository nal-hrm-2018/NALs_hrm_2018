<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 4/11/2018
 * Time: 7:34 AM
 */

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class AbsenceAddRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'absence_type_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required|after:startwork_date',
            'reason' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'absence_type_id.required' => trans('validation.required', [
                'attribute' => 'Absence Type'
            ]),

            'reason.required' => trans('validation.required', [
                'attribute' => 'Reason'
            ]),
            'start_date.required' => trans('validation.required', [
                'attribute' => 'Start Date'
            ]),
            'end_date.required' => trans('validation.required', [
                'attribute' => 'End Date'
            ]),
            'end_date.date_format' => trans('validation.date_format', [
                'attribute' => 'End Date',
                'format' => 'yyyy-MM-dd HH:mm'
            ]),
        ];
    }
}