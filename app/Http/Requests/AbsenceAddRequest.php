<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 4/11/2018
 * Time: 7:34 AM
 */

namespace App\Http\Requests;


use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AbsenceAddRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $curDate = date_create(Carbon::now()->format('Y-m-d'));
        $dayBefore = ($curDate)->modify('-15 day')->format('d-m-Y');
        $objEmp=Employee::SELECT("*")
                            ->where('id','=',Auth::id())
                            ->first();
        $dayAfter=$objEmp["endwork_date"];
        if(isset($dayAfter)){
             $dayAfter = date('d-m-Y', strtotime($dayAfter));
            return [
                'absence_type_id' => 'required',
                'absence_time_id' => 'required',
                'from_date' => 'required|after:'.$dayBefore,
                'to_date' => 'required|after_or_equal:from_date|before:'.$dayAfter,
                'reason' => 'required'
            ];
        }else{
            return [
                'absence_type_id' => 'required',
                'absence_time_id' => 'required',
                'from_date' => 'required|after:'.$dayBefore,
                'to_date' => 'required|after_or_equal:from_date',
                'reason' => 'required'
            ];
        }
       
    }

    public function messages()
    {
        return [
            'absence_type_id.required' => trans('validation.required', [
                'attribute' => trans('absence.absence_type')
            ]),

            'absence_time_id.required' => trans('validation.required', [
                'attribute' => trans('absence.absence_time')
            ]),

            'reason.required' => trans('validation.required', [
                'attribute' => trans('absence.reason')
            ]),
            'from_date.required' => trans('validation.required', [
                'attribute' => trans('absence.start_date')
            ]),
            'to_date.required' => trans('validation.required', [
                'attribute' => trans('absence.end_date')
            ]),
            'to_date.date_format' => trans('validation.date_format', [
                'attribute' => trans('absence.start_date'),
                'format' => 'yyyy-MM-dd'
            ]),
            'from_date.date_format' => trans('validation.date_format', [
                'attribute' => trans('absence.end_date'),
                'format' => 'yyyy-MM-dd'
            ]),
            'to_date.after' => trans('validation.after', [
                'attribute' => 'ngày kết thúc',
                'date'=> trans('absence.start_date')
            ]),
            'from_date.after' => trans('validation.after', [
                'attribute' => trans('absence.start_date')
            ]),
            'to_date.before' => trans('validation.before', [
                'attribute' => trans('absence.end_date'),
            ])
        ];
    }
}