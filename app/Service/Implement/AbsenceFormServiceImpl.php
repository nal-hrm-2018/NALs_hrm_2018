<?php
/**
 * Created by PhpStorm.
 * User: Ngoc Quy
 * Date: 6/21/2018
 * Time: 1:35 PM
 */

namespace App\Service\Implement;

use App\Models\Absence;
use App\Models\Confirm;
use App\Models\Process;
use App\Service\AbsenceFormService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsenceFormServiceImpl implements AbsenceFormService
{
    public function addNewAbsenceForm(Request $request)
    {
        $id_employee = Auth::user()->id;

        $date = Carbon::now()->format('Y-m-d H:i:s');;

        if (strtotime($request->get('from_date')) < strtotime($date)) {
            $is_late = 1;
        } else {
            $is_late = 0;
        }

        $objProcess = Process::select('*')
                    ->where('employee_id', '=', $id_employee)
                    ->whereDate('processes.end_date', '>=', $date)
                    ->get()
                    ->toArray();
        if (empty($objProcess)) {
            $is_process = 0;
        } else {
            $is_process = 1;
        }

        $data =[
            'employee_id'=>$id_employee,
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



        $objAbsence=Absence::create($data);

        if(is_null($objAbsence)){
            \Session::flash('msg_fail', 'Account failed created!!!');
            return back()->withInput(Input::all());
        }else{

            $data1 =[
                'reason'=>$request->get('reason'),
                'created_at'=>new \DateTime(),
                'delete_flag'=>0,
                'absence_status_id'=>1,
                'absence_type_id'=>$request->get('absence_type_id'),
                'absence_id'=> $objAbsence->id,
                'is_process'=>$is_process,
                'employee_id'=>$id_employee
            ];

            Confirm::create($data1);

            \Session::flash('msg_success', 'Form successfully created!!!');
            return redirect('absences');
        }
    }
}