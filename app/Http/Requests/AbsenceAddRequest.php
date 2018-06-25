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
            'from_date' => 'required',
            'to_date' => 'required|after:from_date',
            'reason' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'absence_type_id.required' => trans('validation.required', [
                'attribute' => 'loại nghỉ phép'
            ]),

            'reason.required' => trans('validation.required', [
                'attribute' => 'lý do'
            ]),
            'from_date.required' => trans('validation.required', [
                'attribute' => 'nghỉ từ ngày'
            ]),
            'to_date.required' => trans('validation.required', [
                'attribute' => 'đến ngày'
            ]),
            'to_date.date_format' => trans('validation.date_format', [
                'attribute' => 'nghỉ từ ngày',
                'format' => 'yyyy-MM-dd HH:mm'
            ]),
            'from_date.date_format' => trans('validation.date_format', [
                'attribute' => 'dến ngày',
                'format' => 'yyyy-MM-dd HH:mm'
            ]),
            'to_date.after' => trans('validation.after', [
                'attribute' => 'ngày kết thúc',
                'date'=>'bắt đầu nghỉ'
            ]),
        ];
    }
}