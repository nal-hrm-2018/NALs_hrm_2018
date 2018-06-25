<?php
/**
 * Created by PhpStorm.
 * User: Ngoc Quy
 * Date: 6/21/2018
 * Time: 1:35 PM
 */

namespace App\Service\Implement;


use App\Models\Confirm;
use App\Service\AbsenceFormService;
use App\Service\AbsencePoTeamService;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AbsenceFormServiceImpl implements AbsenceFormService
{
    public function addNewAbsenceForm(Request $request)
    {
        $absence_form = new Absence;
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
        $absence_form->created_at = new DateTime;
        $absence_form->delete_flag = 0;

        if ($absence_form->save()) {
            \Session::flash('msg_success', 'Form successfully created!!!');
            return redirect('absences');
        } else {
            \Session::flash('msg_fail', 'Account failed created!!!');
            return back()->with(['absences' => $absence_form]);
        }
    }
}