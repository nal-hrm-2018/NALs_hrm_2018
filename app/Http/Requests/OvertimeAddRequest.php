<?php
    /**
     * Created by PhpStorm.
     * User: PC
     * Date: 4/11/2018
     * Time: 7:34 AM
     */

    namespace App\Http\Requests;


    use Illuminate\Foundation\Http\FormRequest;
    use Illuminate\Support\Facades\Auth;
    use App\Models\Process;

    class OvertimeAddRequest extends FormRequest
    {
        public function authorize()
        {
            return true;
        }

        public function rules()
        {
            $project = new Process();
            $countProject = $project->countProcess();
            if($countProject > 0){
                return [
                    'project_id' => 'required' ,
                    'date' => 'required',
                    'start_time' => 'required',
                    'end_time' => 'required|after:start_time',
                    'total_time' => 'required|numeric|min:0',
                    'reason' => 'required',
//                    'overtime_type_id' => 'required',
                ];
            }else{
                return [
                    'date' => 'required',
                    'start_time' => 'required',
                    'end_time' => 'required' ,
                    'total_time' => 'required|numeric|min:0',
                    'reason' => 'required',
//                    'overtime_type_id' => 'required',
                ];
            }

        }

        public function messages()
        {
            return [
                'project_id.required' => trans('validation.required', [
                    'attribute' => trans('overtime.project')
                ]),
                'date.required' => trans('validation.required', [
                    'attribute' => trans('overtime.date')
                ]),
                'start_time.required' => trans('validation.required', [
                    'attribute' => trans('overtime.start_time')
                ]),
//                'overtime_type_id.required' => trans('validation.required', [
//                    'attribute' => trans('overtime.overtime_type_id')
//                ]),
                'end_time.required' => trans('validation.required', [
                    'attribute' => trans('overtime.end_time')
                ]),
                'end_time.after' => trans('validation.after_hours', [
                    'attribute' => trans('overtime.end_time'),
                    'date' => trans('overtime.start_time'),
                ]),
                'total_time.required' => trans('validation.required', [
                    'attribute' => trans('overtime.total_time')
                ]),
                'total_time.min' => trans('validation.min_total_time', [
                    'attribute' => trans('overtime.total_time')
                ]),
                'reason.required' => trans('validation.required', [
                    'attribute' => trans('overtime.reason')
                ])
            ];
        }
    }