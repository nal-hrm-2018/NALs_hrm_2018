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
use App\Models\Employee;
use App\Models\Process;
use App\Models\Role;
use App\Service\AbsenceFormService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsenceFormServiceImpl implements AbsenceFormService
{
    public function addNewAbsenceForm(Request $request)
    {
        $id_employee = Auth::user()->id;
        $date = Carbon::now()->format('Y-m-d');
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
        $poTeam= Employee::find($id_employee)->teams();
        $arrayList = array();
        $from_date = $request->get('from_date');
        $from_date_year = date('Y',strtotime($from_date));
        $to_date = $request->get('to_date');
        $to_date_year = date('Y',strtotime($to_date));
        
        $absences = Absence::with('absenceTime')->where('delete_flag', 0)->where('employee_id', $id_employee)->get()->toArray();

        foreach($absences as $absence){
            
            if( ($from_date >= $absence['from_date'] && $from_date <= $absence['to_date']) || ($to_date >= $absence['from_date'] && $to_date <= $absence['to_date']) ){
                if($request->get('absence_time_id') == 1){
                    \Session::flash('msg_fail', 'From Date or To Date Duplicate!!!');
                    return back()->withInput();
                }
                if($absence['absence_time']['name'] == 'all'){
                    \Session::flash('msg_fail', 'From Date or To Date Duplicate!!!');
                    return back()->withInput();
                }
                if($absence['absence_time']['name'] == 'morning'){
                    if($absence['absence_time']['id'] == $request->get('absence_time_id')){
                        \Session::flash('msg_fail', 'From Date or To Date Duplicate!!!');
                        return back()->withInput();
                    }
                }
                if($absence['absence_time']['name'] == 'afternoon'){
                    if($absence['absence_time']['id'] == $request->get('absence_time_id')){
                        \Session::flash('msg_fail', 'From Date or To Date Duplicate!!!');
                        return back()->withInput();
                    }
                }
            }
        }    

        if($from_date_year == $to_date_year){
            $data = [
                'employee_id' => $id_employee,
                'absence_type_id' => $request->get('absence_type_id'),
                'absence_time_id' => $request->get('absence_time_id'),
                'from_date' => $request->get('from_date'),
                'to_date' => $request->get('to_date'),
                'reason' => $request->get('reason'),
                'absence_status_id' => 2,
                'created_at' => new \DateTime(),
                'delete_flag' => 0,
                'is_deny' => 0,
                'is_late' => $is_late,
                'description' => $request->get('ghi_chu')
            ];
    
            
            $objAbsence = Absence::create($data);
        }else{
            $data1 = [
                'employee_id' => $id_employee,
                'absence_type_id' => $request->get('absence_type_id'),
                'absence_time_id' => $request->get('absence_time_id'),
                'from_date' => $request->get('from_date'),
                'to_date' => $from_date_year.'-12-31',
                'reason' => $request->get('reason'),
                'absence_status_id' => 2,
                'created_at' => new \DateTime(),
                'delete_flag' => 0,
                'is_deny' => 0,
                'is_late' => $is_late,
                'description' => $request->get('ghi_chu')
            ];
            $objAbsence = Absence::create($data1);
            $data2 = [
                'employee_id' => $id_employee,
                'absence_type_id' => $request->get('absence_type_id'),
                'absence_time_id' => $request->get('absence_time_id'),
                'from_date' => $to_date_year.'-01-01',
                'to_date' => $request->get('to_date'),
                'reason' => $request->get('reason'),
                'absence_status_id' => 2,
                'created_at' => new \DateTime(),
                'delete_flag' => 0,
                'is_deny' => 0,
                'is_late' => $is_late,
                'description' => $request->get('ghi_chu')
            ];
            $objAbsence = Absence::create($data2);
        }


        if (is_null($objAbsence)) {
            \Session::flash('msg_fail', 'Account failed created!!!');
            return back()->withInput(Input::all());
        } else {
            \Session::flash('msg_success', 'Thêm mới Form thành công!!!');
            return redirect()->route('absences.index');
        }
    }
    public function editAbsenceForm(Request $request, $id)
    {
        $id_employee = Absence::where('id',$id)->first()->employee_id; 
        $id_user = Auth::user()->id;
        $date = Carbon::now()->format('Y-m-d');
        if (strtotime($request->get('from_date')) < strtotime($date)) {
            $is_late = 1;
        } else {
            $is_late = 0;
        }
//        $objProcess = Process::select('*')
//            ->where('employee_id', '=', $id_employee)
//            ->whereDate('processes.end_date', '>=', $date)
//            ->get()
//            ->toArray();

//        $employeeLogged = Employee::where('id', $id_employee)->first();
//
//        $poTeam = Employee::select('*')->where('is_manager', 1)
//            ->where('team_id', $employeeLogged->team_id)->first();
//        $arrayList = array();
        $from_date = $request->get('from_date');
        $from_date_year = date('Y',strtotime($from_date));
        $to_date = $request->get('to_date');
        $to_date_year = date('Y',strtotime($to_date));
        $from_date = date('Y-m-d',strtotime($from_date));;
        $to_date = date('Y-m-d',strtotime($to_date));;
            
        $absences = Absence::with('absenceTime')->where('delete_flag', 0)->where('employee_id', $id_employee)->where('id', '!=', $id)->get()->toArray();

        foreach($absences as $absence){
            
            if( ($from_date >= $absence['from_date'] && $from_date <= $absence['to_date']) || ($to_date >= $absence['from_date'] && $to_date <= $absence['to_date']) ){
                if($request->get('absence_time_id') == 1){
                    \Session::flash('msg_fail', 'From Date or To Date Duplicate!!!');
                    return back()->withInput();
                }
                if($absence['absence_time']['name'] == 'all'){
                    \Session::flash('msg_fail', 'From Date or To Date Duplicate!!!');
                    return back()->withInput();
                }
                if($absence['absence_time']['name'] == 'morning'){
                    if($absence['absence_time']['id'] == $request->get('absence_time_id')){
                        \Session::flash('msg_fail', 'From Date or To Date Duplicate!!!');
                        return back()->withInput();
                    }
                }
                if($absence['absence_time']['name'] == 'afternoon'){
                    if($absence['absence_time']['id'] == $request->get('absence_time_id')){
                        \Session::flash('msg_fail', 'From Date or To Date Duplicate!!!');
                        return back()->withInput();
                    }
                }
            }
        }   
        if($from_date_year == $to_date_year){
            $data = [
                'employee_id' => $id_employee,
                'absence_type_id' => $request->get('absence_type_id'),
                'absence_time_id' => $request->get('absence_time_id'),
                'from_date' => $from_date,
                'to_date' => $to_date,
                'reason' => $request->get('reason'),
                'absence_status_id' => 2,
                'delete_flag' => 0,
                'is_deny' => 0,
                'is_late' => $is_late,
                'description' => $request->get('ghi_chu'),
                'updated_by_employee' => $id_user,
            ];
            $objAbsence = Absence::where('delete_flag', 0)->findOrFail($id)->update($data);
        }else{
            $data1 = [
                'employee_id' => $id_employee,
                'absence_type_id' => $request->get('absence_type_id'),
                'absence_time_id' => $request->get('absence_time_id'),
                'from_date' => $request->get('from_date'),
                'to_date' => $from_date_year.'-12-31',
                'reason' => $request->get('reason'),
                'absence_status_id' => 2,
                'created_at' => new \DateTime(),
                'delete_flag' => 0,
                'is_deny' => 0,
                'is_late' => $is_late,
                'description' => $request->get('ghi_chu')
            ];
            $objAbsence = Absence::where('delete_flag', 0)->findOrFail($id)->update($data1);
            $data2 = [
                'employee_id' => $id_employee,
                'absence_type_id' => $request->get('absence_type_id'),
                'absence_time_id' => $request->get('absence_time_id'),
                'from_date' => $to_date_year.'-01-01',
                'to_date' => $request->get('to_date'),
                'reason' => $request->get('reason'),
                'absence_status_id' => 2,
                'created_at' => new \DateTime(),
                'delete_flag' => 0,
                'is_deny' => 0,
                'is_late' => $is_late,
                'description' => $request->get('ghi_chu')
            ];
            $objAbsence = Absence::create($data2);
        }


        // $data = [
        //     'employee_id' => $id_employee,
        //     'absence_type_id' => $request->get('absence_type_id'),
        //     'absence_time_id' => $request->get('absence_time_id'),
        //     'from_date' => $request->get('from_date'),
        //     'to_date' => $request->get('to_date'),
        //     'reason' => $request->get('reason'),
        //     'absence_status_id' => 2,
        //     'created_at' => new \DateTime(),
        //     'delete_flag' => 0,
        //     'is_deny' => 0,
        //     'is_late' => $is_late,
        //     'description' => $request->get('ghi_chu')
        // ];
        // $objAbsence = Absence::where('delete_flag', 0)->findOrFail($id)->update($data);

//        if (is_null($objAbsence)) {
//            \Session::flash('msg_fail', 'Account failed created!!!');
//            return back()->withInput(Input::all());
//        } else {
//            if (empty($objProcess)) {
////                $is_process = 0;
//                $data1 = [
//                    'created_at' => new \DateTime(),
//                    'delete_flag' => 0,
//                    'absence_status_id' => 1,
//                    'absence_id' => $objAbsence['id'],
//                    'is_process' => null,
//                    'employee_id' => $poTeam->id
//                ];
//       Confirm::where('delete_flag', 0)->where('absence_id',$id)->update($data1);
//
//            } else {
////                $is_process = 1;
//                $getIdRolePo = Role::where('name', 'PO')->first();
//                $indexInLoop = 0;
//
//                foreach ($objProcess as $element) {
//                    $arrayList[$indexInLoop] = Process::where('project_id', $element['project_id'])
//                        ->where('role_id', $getIdRolePo->id)
//                        ->whereDate('start_date', '<=', $request->get('from_date'))
//                        ->whereDate('end_date', '>=', $request->get('to_date'))
//                        ->first();
//                    $indexInLoop++;
//                }
//
//                foreach ($arrayList as $key => $value) {
//                    if (!empty($value)) {
//                        $data1 = [
//                            'created_at' => new \DateTime(),
//                            'delete_flag' => 0,
//                            'absence_status_id' => 1,
//                            'absence_id' => $objAbsence['id'],
//                            'project_id' => $value['project_id'],
//                            'employee_id' => $value['employee_id']
//                        ];
//                        Confirm::where('delete_flag', 0)->where('absence_id',$id)->update($data1);
//                    }
//                }
//
//                $dataPoTeamJustWatch = [
//                    'created_at' => new \DateTime(),
//                    'delete_flag' => 0,
//                    'absence_status_id' => 1,
//                    'absence_id' => $objAbsence['id'],
//                    'project_id' => null,
//                    'employee_id' => $poTeam->id
//                ];
//                Confirm::where('delete_flag', 0)->where('absence_id',$id)->update($dataPoTeamJustWatch);
//            }
            if (is_null($objAbsence)) {
                \Session::flash('msg_fail', 'Account failed update!!!');
                return back()->withInput(Input::all());
            } else {
                \Session::flash('msg_success', trans('absence.msg_edit.success'));
                return redirect('employee/'.$id_employee.'?basic=0&project=0&overtime=0&absence=1');
            }
            // \Session::flash('msg_success', trans('absence.msg_edit.success'));
            // return redirect()->route('employee.show',['employee'=>$id_employee]);
//        }
    }
}