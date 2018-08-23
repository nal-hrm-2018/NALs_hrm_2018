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
        $date = Carbon::now()->format('Y-m-d H:i:s');
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
//        $employeeLogged = Employee::where('id', $id_employee)->first();
//
//        $poTeam = Employee::find($id_employee)
//            ->where('is_manager', 1)
//            ->where('team_id', $employeeLogged->team_id)->first();
        $poTeam= Employee::find($id_employee)->teams();
        $arrayList = array();

        $data = [
            'employee_id' => $id_employee,
            'absence_type_id' => $request->get('absence_type_id'),
            'from_date' => $request->get('from_date'),
            'to_date' => $request->get('to_date'),
            'reason' => $request->get('reason'),
            'absence_status_id' => 1,
            'created_at' => new \DateTime(),
            'delete_flag' => 0,
            'is_deny' => 0,
            'is_late' => $is_late,
            'description' => $request->get('ghi_chu')
        ];


        $objAbsence = Absence::create($data);

        if (is_null($objAbsence)) {
            \Session::flash('msg_fail', 'Account failed created!!!');
            return back()->withInput(Input::all());
        } else {
                    $PO=Role::where('name','PO')->first();
                    $objProcess = Process::where('employee_id',$id_employee)->get();
                    foreach($objProcess as $objP){
                        $project_id = $objP->project_id;
                        $id_poTeam = Process::where('project_id',$project_id)
                                            ->where('role_id',$PO->id)->first();
                        $dataPoTeamJustWatch = [
                                'created_at' => new \DateTime(),
                                'delete_flag' => 0,
                                'absence_status_id' => 1,
                                'absence_type_id' => $request->get('absence_type_id'),
                                'absence_id' => $objAbsence->id,
                                'project_id' => null,
                                'employee_id' => $employee_id,
                            ];
                        Confirm::create($dataPoTeamJustWatch);
                    }

            \Session::flash('msg_success', 'Thêm mới Form thành công!!!');
            return redirect()->route('absences.index');
        }
    }
    public function editAbsenceForm(Request $request, $id)
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

        $employeeLogged = Employee::where('id', $id_employee)->first();

        $poTeam = Employee::select('*')->where('is_manager', 1)
            ->where('team_id', $employeeLogged->team_id)->first();
        $arrayList = array();

        $data = [
            'employee_id' => $id_employee,
            'absence_type_id' => $request->get('absence_type_id'),
            'from_date' => $request->get('from_date'),
            'to_date' => $request->get('to_date'),
            'reason' => $request->get('reason'),
            'absence_status_id' => 1,
            'created_at' => new \DateTime(),
            'delete_flag' => 0,
            'is_deny' => 0,
            'is_late' => $is_late,
            'description' => $request->get('ghi_chu')
        ];
        $objAbsence = Absence::where('delete_flag', 0)->findOrFail($id)->update($data);

        if (is_null($objAbsence)) {
            \Session::flash('msg_fail', 'Account failed created!!!');
            return back()->withInput(Input::all());
        } else {
            if (empty($objProcess)) {
//                $is_process = 0;
                $data1 = [
                    'created_at' => new \DateTime(),
                    'delete_flag' => 0,
                    'absence_status_id' => 1,
                    'absence_id' => $objAbsence['id'],
                    'is_process' => null,
                    'employee_id' => $poTeam->id
                ];
       Confirm::where('delete_flag', 0)->where('absence_id',$id)->update($data1);

            } else {
//                $is_process = 1;
                $getIdRolePo = Role::where('name', 'PO')->first();
                $indexInLoop = 0;

                foreach ($objProcess as $element) {
                    $arrayList[$indexInLoop] = Process::where('project_id', $element['project_id'])
                        ->where('role_id', $getIdRolePo->id)
                        ->whereDate('start_date', '<=', $request->get('from_date'))
                        ->whereDate('end_date', '>=', $request->get('to_date'))
                        ->first();
                    $indexInLoop++;
                }

                foreach ($arrayList as $key => $value) {
                    if (!empty($value)) {
                        $data1 = [
                            'created_at' => new \DateTime(),
                            'delete_flag' => 0,
                            'absence_status_id' => 1,
                            'absence_id' => $objAbsence['id'],
                            'project_id' => $value['project_id'],
                            'employee_id' => $value['employee_id']
                        ];
                        Confirm::where('delete_flag', 0)->where('absence_id',$id)->update($data1);
                    }
                }

                $dataPoTeamJustWatch = [
                    'created_at' => new \DateTime(),
                    'delete_flag' => 0,
                    'absence_status_id' => 1,
                    'absence_id' => $objAbsence['id'],
                    'project_id' => null,
                    'employee_id' => $poTeam->id
                ];
                Confirm::where('delete_flag', 0)->where('absence_id',$id)->update($dataPoTeamJustWatch);
            }

            \Session::flash('msg_success', 'Sửa Form thành công!!!');
            return redirect('absences');
        }
    }
}