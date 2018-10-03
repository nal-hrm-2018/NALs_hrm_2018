<?php
    /**
     * Created by PhpStorm.
     * User: PC
     * Date: 4/11/2018
     * Time: 7:34 AM
     */

    namespace App\Http\Requests;
    use Illuminate\Http\Request;
    use App\Models\Employee;


    use Illuminate\Foundation\Http\FormRequest;

    class QuitEditRequest extends FormRequest
    {
        public function authorize()
        {
            return true;
        }

        public function rules(Request $request)
        {
            $startwork_date = '1-1-1900';
            if ($request->employee !== null){
                $start_time = Employee::where('id',$request->employee)->value('startwork_date');
                $startwork_date = date('d-m-Y', strtotime($start_time));
            }

            return [
                'reason' => 'required',
                // 'notification_type_id' => 'required',
                'quit_date' => 'required|after_or_equal:'.$startwork_date,
            ];
        }

        public function messages()
        {
            return [
                'reason.required' => trans('validation.required', [
                    'attribute' => trans('quit.reason')
                ]),
                'quit_date.required' => trans('validation.required', [
                    'attribute' => trans('quit.quit_date')
                ]),
                'quit_date.after_or_equal' => trans('validation.after_or_equal', [
                    'attribute' => trans('quit.quit_date')
                ]),
            ];
        }
    }