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
        return [
            'absence_type_id' => 'required',
            'from_date' => 'required|after:'.$dayBefore,
            'to_date' => 'required|after_or_equal:from_date|before:'.$dayAfter,
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
            'from_date.after' => trans('validation.after', [
                'attribute' => 'ngày bắt đầu nghỉ',
            ]),
            'to_date.before' => trans('validation.before', [
                'attribute' => 'ngày kết thúc',
            ])
        ];
    }
}