<?php
    /**
     * Created by PhpStorm.
     * User: PC
     * Date: 4/11/2018
     * Time: 7:34 AM
     */

    namespace App\Http\Requests;


    use Illuminate\Foundation\Http\FormRequest;

    class OvertimeAddRequest extends FormRequest
    {
        public function authorize()
        {
            return true;
        }

        public function rules()
        {
            return [
                'project_id' => 'required' ,
                'date' => 'required',
                'start_time' => 'required',
                'end_time' => 'required' ,
                'total_time' => 'required',
                'reason' => 'required',
                'overtime_type_id' => 'required',
                'correct_total_time' => 'required|numeric|min:0'
            ];
        }

        public function messages()
        {
            return [
                'correct_total_time.min' => trans('validation.correct_total_time', [
                    'attribute' => trans('overtime.correct_total_time')
                ]),
                'correct_total_time.required' => trans('validation.required', [
                    'attribute' => trans('overtime.correct_total_time')
                ]),
                'project_id.required' => trans('validation.required', [
                    'attribute' => trans('overtime.project')
                ]),
                'date.required' => trans('validation.required', [
                    'attribute' => trans('overtime.date')
                ]),
                'start_time.required' => trans('validation.required', [
                    'attribute' => trans('overtime.start_time')
                ]),
                'overtime_type_id.required' => trans('validation.required', [
                    'attribute' => trans('overtime.overtime_type_id')
                ]),
                'end_time.required' => trans('validation.required', [
                    'attribute' => trans('overtime.end_time')
                ]),
                'total_time.total_time' => trans('validation.required', [
                    'attribute' => trans('overtime.total_time')
                ]),
                'reason.required' => trans('validation.required', [
                    'attribute' => trans('overtime.reason')
                ])
            ];
        }
    }