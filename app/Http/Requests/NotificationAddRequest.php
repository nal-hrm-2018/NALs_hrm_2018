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
                'notification_id' => 'required',
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
                'notification_id.required' => trans('validation.required', [
                    'attribute' => trans('notification.notification_id')
                ]),
            ];
        }
    }