<?php
    /**
     * Created by PhpStorm.
     * User: PC
     * Date: 4/11/2018
     * Time: 7:34 AM
     */

    namespace App\Http\Requests;


    use Illuminate\Foundation\Http\FormRequest;

    class OvertimeRequest extends FormRequest
    {
        public function authorize()
        {
            return true;
        }

        public function rules()
        {
            
            return [
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
            ];
        }
    }