<?php
    /**
     * Created by PhpStorm.
     * User: PC
     * Date: 4/11/2018
     * Time: 7:34 AM
     */

    namespace App\Http\Requests;


    use Illuminate\Foundation\Http\FormRequest;

    class NotificationAddRequest extends FormRequest
    {
        public function authorize()
        {
            return true;
        }

        public function rules()
        {
            return [
                'title' => 'required' ,
                'content' => 'required',
                // 'notification_type_id' => 'required',
                'date' => 'required|after_or_equal:' . date('d-m-Y'),
            ];
        }

        public function messages()
        {
            return [
                'title.required' => trans('validation.required', [
                    'attribute' => trans('notification.title')
                ]),
                'content.required' => trans('validation.required', [
                    'attribute' => trans('notification.content')
                ]),
                'date.required' => trans('validation.required', [
                    'attribute' => trans('notification.end_date')
                ]),
                'date.after_or_equal' => trans('validation.after_or_equal', [
                    'attribute' => trans('notification.end_date')
                ]),
                // 'notification_type_id.required' => trans('validation.required', [
                //     'attribute' => trans('notification.notification_id')
                // ]),
            ];
        }
    }