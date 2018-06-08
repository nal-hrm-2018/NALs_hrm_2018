<?php

use App\Http\Requests\ProcessAddRequest;
use Illuminate\Support\Facades\Validator;
use App\Models\Employee;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\MessageBag;

function test()
{
    return "test helper";
}

function getProjectStatus($project)
{
    if (isset($project->status)) {
        return $project->status->name;
    }
    return '';
}

function getArraySelectOption()
{
    $array = ['20' => '20', '50' => '50', '100' => '100'];

    return $array;
}

function array_has_dupes($array)
{
    return count($array) !== count(array_flip($array));
}

function getRoleofVendor($vendor)
{
    $text = "";
    $arr_roles = array_unique($vendor->roles()->pluck('name')->toArray());
    if (!empty($processes)) {
        foreach ($arr_roles as $key => $value) {
            if ($key === count($arr_roles) - 1) {
                $text = $text . $value;
            } else {
                $text = $text . $value . ",";
            }
        }
    }
    return $text;
}

function getTotalManPowerofProcesses($processes)
{
    $total = 0;
    if (!empty($processes)) {
        foreach ($processes as $item) {
            $total = $total + $item->man_power;
        }
    }
    return $total;
}

function getArrayManPower()
{
    return [0.125, 0.25, 0.5, 0.75, 1];
}

function hasDupeProject($processes, $start_date_process, $end_date_process, $key, $value, $employee_name_selected)
{
    $start_date_process_selected = Carbon::parse($start_date_process);
    $end_date_process_selected = Carbon::parse($end_date_process);
    $count = 0;
    if (!empty($processes)) {
        foreach ($processes as $process) {
            if (!is_null($process['delete_flag']) && $process['delete_flag'] !== '0') {
                continue;
            }

            if ($process[$key] === $value) {
                $start_date_process = Carbon::parse($process['start_date_process']);
                $end_date_process = Carbon::parse($process['end_date_process']);
                if ($start_date_process->gte($end_date_process_selected) || $start_date_process_selected->gte($end_date_process)) {
                    continue;
                }
                $count++;
                if ($count > 1) {
                    if ($key === 'employee_id') {
                        $string_error = $employee_name_selected . " ( id = " . $value . " )" . " Can't add because " .
                            " from : " . date('d/m/Y', strtotime($process['start_date_process'])) . " to: "
                            . date('d/m/Y', strtotime($process['end_date_process'])) . " you be added to this project";
                        return $string_error;
                    }
                    if ($key === 'role_id') {
                        $employee_name = Employee::select('name')->where('id', $process['employee_id'])->first();
                        if (!is_null($employee_name)) {
                            $employee_name = $employee_name->name;
                        } else {
                            $employee_name = '';
                        }
                        $string_error = $employee_name_selected . " Can't add because " .
                            " from : " . date('d/m/Y', strtotime($process['start_date_process'])) . " to: "
                            . date('d/m/Y', strtotime($process['end_date_process'])) . " has PO is " . $employee_name;
                        return $string_error;
                    }
                }
            }
        }
        return false;
    }
    return false;
}

function checkValidProjectData()
{
    // ham nay sinh ra de chong lai tinh trang thay doi thong tin project sau khi da add process
    $processes = request()->get('processes');
    $processAddRequest = new ProcessAddRequest();
    $error_messages = array();
    if (!empty($processes)) {
        //kiem tra processes phai co it nhat 1 po
        if (!checkPOinProject($processes)) {
            return false;
        }
        //validate cac process
        foreach ($processes as $key => $process) {
            $validator = Validator::make(
                $process,
                $processAddRequest->ruleReValidate(
                    \request()->get('estimate_start_date'),
                    \request()->get('estimate_end_date'),
                    \request()->get('start_date_project'),
                    \request()->get('end_date_project'),
                    request()->get('project_id'),
                    $process,
                    $processes
                ),
                $processAddRequest->messages()
            );
            if ($validator->fails()) {
                // key = id  process , value = messagebag of validate
                $error_messages[$key] = $validator->messages();
            }
        }
        if (!empty($error_messages)) {
            session()->flash('error_messages', $error_messages);
            return false;
        } else {
            return true;
        }

    } else {
        $bag = new MessageBag();
        $bag->add('PO_process', 'Project must have at least 1 PO ');
        session()->flash('errors', $bag);
        return false;
    }
}

function getEmployee($id)
{
    return Employee::find($id);
}

function getRole($id)
{
    return Role::where('delete_flag', '=', 0)->find($id);
}

function getIdEmployeefromProcessError($data)
{
    if (!empty($data)) {
        $rs = explode('_', $data, 2);
        return $rs[0];
    }
    return '';
}

function showListAvailableProcesses($available_processes)
{
    $string_available_processes = '';
    foreach ($available_processes as $process) {
        $string_available_processes = $string_available_processes .
            " project_id : " . $process['project_id'] .
            " man_power : " . $process['man_power'] .
            " start_date : " . date('d/m/Y', strtotime($process['start_date'])) .
            " end_date : " . date('d/m/Y', strtotime($process['start_date'])) . "\n";
    }

    $string_total = "You can view suggest information of this employee : \n" + $string_available_processes;
}

function getInformationDataTable($pagination)
{
    return "Showing " . $pagination->firstItem() . " to " . $pagination->lastItem() . " of " . $pagination->total() . " entries";

}

function checkPOinProject($processes)
{
    $id_po = Role::select('id')->where('delete_flag', 0)->where('name', '=', config('settings.Roles.PO'))->first();
    if (!is_null($id_po)) {
        $id_po = (string)Role::select('id')->where('delete_flag', 0)->where('name', '=', config('settings.Roles.PO'))->first()->id;
    } else {
        $bag = new MessageBag();
        $bag->add('error_role', "Role PO not exist in database");
        session()->flash('errors', $bag);
        return false;
    }
    foreach ($processes as $key => $process) {
        if($process['delete_flag']==='1'){
            continue;
        }
        if ($process['role_id'] === $id_po) {
            return true;
        }
    }
    $bag = new MessageBag();
    $bag->add('PO_process', 'Project must have at least 1 PO ');
    session()->flash('errors', $bag);
    return false;
}