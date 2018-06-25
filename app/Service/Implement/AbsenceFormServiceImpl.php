<?php
/**
 * Created by PhpStorm.
 * User: Ngoc Quy
 * Date: 6/21/2018
 * Time: 1:35 PM
 */

namespace App\Service\Implement;


use App\Models\Absence;
use App\Service\AbsenceFormService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsenceFormServiceImpl implements AbsenceFormService
{
    public function addNewAbsenceForm(Request $request)
    {
    /*    $absence_form = new Absence();
        $absence_form->employee_id = Auth::user()->id;
        $absence_form->absence_type_id = $request->absence_type_id;
        $absence_form->name = $request->name;
        $absence_form->from_date = $request->from_date;
        $absence_form->to_date = $request->to_date;
        $date = Carbon::now()->format('Y-m-d H:i:s');;
        if (strtotime($absence_form->to_date) < strtotime($date)) {
            $absence_form->is_late = 0;
        } else {
            $absence_form->is_late = 1;
        }
        $absence_form->reason = $request->reason;
        $absence_form->absence_status_id = $request->absence_status_id;
        $absence_form->created_at = new \DateTime();
        $absence_form->delete_flag = 0;

        if ($absence_form->save()) {
            \Session::flash('msg_success', 'Form successfully created!!!');
            return redirect('absences');
        } else {
            \Session::flash('msg_fail', 'Form failed created!!!');
            return back()->with(['absences' => $absence_form]);
        }*/

        $date = Carbon::now()->format('Y-m-d H:i:s');;
        if (strtotime($request->to_date) < strtotime($date)) {
            $is_late = 1;
        } else {
            $is_late = 0;
        }

        $data =[
            'employee_id'=>Auth::user()->id,
            'absence_type_id'=>$request->get('absence_type_id'),
            'from_date'=>$request->get('from_date'),
            'to_date'=>$request->get('to_date'),
            'reason'=>$request->get('reason'),
            'absence_status_id'=>1,
            'created_at'=>new \DateTime(),
            'delete_flag'=>0,
            'is_deny'=>0,
            'is_late'=>$is_late,
            'description'=>$request->get('ghi_chu')
        ];

        if(is_null(Absence::create($data))){
            \Session::flash('msg_fail', 'Account failed created!!!');
            return back()->withInput(Input::all());
        }else{
            \Session::flash('msg_success', 'Form successfully created!!!');
            return redirect('absences');
        }


    }
}