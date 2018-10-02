<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 4/11/2018
 * Time: 7:34 AM
 */

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Process;
use App\Models\Employee;
use App\Models\DayType;
use App\Models\HolidayDefault;
use App\Models\Holiday;

class OvertimeAddRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(Request $request)
    {
        $start_time_H = date('H', strtotime($request->start_time));
        $start_time_I = date('i', strtotime($request->start_time));
        $end_time_H = date('H', strtotime($request->end_time));
        $end_time_I = date('i', strtotime($request->end_time));
        if(strtotime($request->end_time) > strtotime($request->start_time)){
            $max_time = ($end_time_H*60+$end_time_I)/60 - ($start_time_H*60+$start_time_I)/60;
        }else{
            $max_time = ($start_time_H*60+$start_time_I)/60 - ($end_time_H*60+$end_time_H)/60;
        }
        $dayStart = Employee::where('id','=',Auth::id())->first()->startwork_date;
        $dayStarts = date('d-m-Y', strtotime($dayStart));

        $project = new Process();
        $countProject = $project->countProcess();

        $dayType = DayType::all()->toArray();
        $typeId = [];
        //Get day type id 
        foreach($dayType  as $val){
            $typeId[$val['name']] = $val['id'];
        }
        $sttHoliday = 1;
        if(date('N', strtotime($request->date)) >= 6){
            $sttHoliday = 2;
        }

        //kiểm tra co phải ngày nghĩ lễ không.
        $holiday = HolidayDefault::all();
        foreach ($holiday as $holiday){
            $holidayDefault = date_format($holiday->date,"m-d");
            $holidayRequest = date('m-d', strtotime($request->date));
            if($holidayDefault == $holidayRequest){
                $sttHoliday = $typeId['holiday'];
                break;
            }
        }
        //Kiểm tra co phải ngày nghĩ đột xuất k
        if ($sttHoliday  == 1){
            $holidays = Holiday::with('type')->get();
            foreach ($holidays as $holiday){
                $holiday->type->name;
                $holidayAdded = $holiday->date->format('Y-m-d');
                $holidayRequest = date('Y-m-d', strtotime($request->date));
                if($holidayAdded == $holidayRequest){
                    $sttHoliday = $typeId[$holiday->type->name];
                }
            }
        }
        if($countProject > 0){
            if($sttHoliday == 1){
                if(strtotime($request->start_time) >= strtotime('12:00')){
                    return [
                        'process_id' => 'required' ,
                        'date' => 'required|after_or_equal:'.$dayStarts,
                        'start_time' => 'required|after:18:29',
                        'end_time' => 'required|after:start_time',
                        'total_time' => 'required|numeric|min:0.1|max:'.$max_time,
                        'reason' => 'required',
                    ];
                }else{
                    return [
                        'process_id' => 'required' ,
                        'date' => 'required|after_or_equal:'.$dayStarts,
                        'start_time' => 'required|before:8:00',
                        'end_time' => 'required|after:start_time|before:8:00',
                        'total_time' => 'required|numeric|min:0.1|max:'.$max_time,
                        'reason' => 'required',
                    ];
                }
            }else{
                return [
                    'process_id' => 'required' ,
                    'date' => 'required|after_or_equal:'.$dayStarts,
                    'start_time' => 'required',
                    'end_time' => 'required|after:start_time',
                    'total_time' => 'required|numeric|min:0.1|max:'.$max_time,
                    'reason' => 'required',
                ];
            }
        }else{
            if($sttHoliday == 1){
                if(strtotime($request->start_time) >= strtotime('12:00')){
                    return [
                        'date' => 'required|after_or_equal:'.$dayStarts,
                        'start_time' => 'required|after:18:29',
                        'end_time' => 'required|after:start_time',
                        'total_time' => 'required|numeric|min:0.1|max:'.$max_time,
                        'reason' => 'required',
                    ];
                }else{
                    return [
                        'date' => 'required|after_or_equal:'.$dayStarts,
                        'start_time' => 'required|before:8:00',
                        'end_time' => 'required|after:start_time|before:8:00',
                        'total_time' => 'required|numeric|min:0.1|max:'.$max_time,
                        'reason' => 'required',
                    ];
                }
            }else{
                return [
                    'date' => 'required|after_or_equal:'.$dayStarts,
                    'start_time' => 'required',
                    'end_time' => 'required' ,
                    'total_time' => 'required|numeric|min:0.1',
                    'reason' => 'required',
                ];
            }
        }

    }

    public function messages()
    {
        return [
            'process_id.required' => trans('validation.required', [
                'attribute' => trans('overtime.project')
            ]),
            'date.required' => trans('validation.required', [
                'attribute' => trans('overtime.date')
            ]),
//                'date.after_or_equal' => trans('validation.after_or_equal', [
//                    'attribute' => trans('overtime.date'),
//                    'date' => $dayStarts
//                ]),
            'start_time.required' => trans('validation.required', [
                'attribute' => trans('overtime.start_time')
            ]),
            'start_time.after' => trans('validation.after_hours', [
                'attribute' => trans('overtime.start_time')
            ]),
            'start_time.before' => trans('validation.before_hours', [
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
            'total_time.numeric' => trans('validation.numeric', [
                'attribute' => trans('overtime.total_time')
            ]),
            'total_time.required' => trans('validation.required', [
                'attribute' => trans('overtime.total_time')
            ]),
            'total_time.min' => trans('validation.min_total_time', [
                'attribute' => trans('overtime.total_time')
            ]),
            'total_time.max' => trans('validation.max_totaltime'),
            'reason.required' => trans('validation.required', [
                'attribute' => trans('overtime.reason')
            ])
        ];
    }
}