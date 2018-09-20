<?php

namespace App\Export;
use App\Models\AbsenceStatus;
use App\Models\Confirm;
use App\Models\Process;
use App\Models\Role;
use App\Models\Team;
use App\Service\SearchConfirmService;
use App\Service\SearchEmployeeService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Employee;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Events\BeforeWriting;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

/**
 * Created by PhpStorm.
 * User: Ngoc Quy
 * Date: 4/23/2018
 * Time: 4:47 PM
 */

class ConfirmExport implements FromCollection,WithEvents, WithHeadings
{
    use Exportable, RegistersEventListeners;
    protected $returnCollectionConfirm;
    /**
     * @var Request
     */
    private $request;


    /**
     * @var Request
     */

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = Confirm::select('confirms.*')->distinct('confirms.id');

        if (!isset($this->request['number_record_per_page'])) {
            $this->request['number_record_per_page'] = config('settings.paginate');
        }

        $params['search'] = [
            'po_id' => !empty($this->request->po_id) ? $this->request->po_id : '',
            'employee_name' => !empty($this->request->employee_name) ? $this->request->employee_name : '',
            'email' => !empty($this->request->email) ? $this->request->email : '',
            'project_id' => !empty($this->request->project_id) ? $this->request->project_id : '',
            'absence_type' => !empty($this->request->absence_type) ? $this->request->absence_type : '',
            'from_date' => !empty($this->request->from_date) ? $this->request->from_date : '',
            'to_date' => !empty($this->request->to_date) ? $this->request->to_date : '',
            'confirm_status' => !empty($this->request->confirm_status) ? $this->request->confirm_status : '',
        ];
        foreach ($params as $key => $value) {
            $po_id = $value['po_id'];
            $employee_name = $value['employee_name'];
            $email = $value['email'];
            $project_id = $value['project_id'];
            $absence_type = $value['absence_type'];
            $from_date = $value['from_date'];
            $to_date = $value['to_date'];
            $confirm_status = $value['confirm_status'];
        }

//        $status = !is_null($this->request->status) ? $this->request->status : '';
        if (!empty($role)) {
            $query
                ->whereHas('role', function ($query) use ($role) {
                    $query->where("name",$role);
                });
        }
        $query->join('absences', 'absences.id', '=', 'confirms.absence_id')
            ->join('employees', 'employees.id', '=', 'absences.employee_id');
//            ->join('processes', 'processes.employee_id', '=', 'employees.id')
//            ->join('projects', 'projects.id', '=', 'processes.project_id');
        if (!empty($employee_name)) {
            $query->where('employees.name', 'like', '%'.$employee_name.'%');
        }
        if (!empty($email)) {
            $query->where('employees.email', 'like', '%'.$email.'%');

        }
        if (!empty($project_id)) {
            $query->where('confirms.project_id', '=', $project_id);

        }
        if (!empty($absence_type)) {
            $query->where('absences.absence_type_id', '=', $absence_type);

        }
        if (!empty($from_date) && !empty($to_date)) {
            $from_date .= ':00';
            $to_date .= ':00';
            $query->where('absences.from_date', '>=', $from_date);
            $query->where('absences.to_date', '<=', $to_date);
        } else if (!empty($from_date) && empty($to_date)) {
            $from_date .= ':00';
            $query->where('absences.from_date', '>=', $from_date);
        } else if (empty($from_date) && !empty($to_date)) {
            $to_date .= ':00';
            $query->where('absences.to_date', '<=', $to_date);
        }
        if (!empty($confirm_status)) {
            $query->where('confirms.absence_status_id', '=', $confirm_status);
        }

       /* if (!is_null($request['status'])) {
            $query->Where('work_status', $request['status']);
        }*/

        $confirmSearch = $query->
            where('confirms.employee_id', '=', $po_id)
                ->where('confirms.project_id', '!=', null)
                ->where('confirms.delete_flag', '=', 0)
                ->orderBy('confirms.id', 'desc')
                ->paginate($this->request['number_record_per_page'], ['confirms.*']);

        $arrayList = array();
        $i = 0;
        $idPO = Role::where('name', '=', config('settings.Roles.PO'))->first()->id;
        $absenceStatus = AbsenceStatus::all();
        $idWaiting = $absenceStatus->where('name', '=', 'waiting')->first()->id;
        $idAccepted = $absenceStatus->where('name', '=', 'accepted')->first()->id;
        $idRejected = $absenceStatus->where('name', '=', 'rejected')->first()->id;
        foreach ($confirmSearch as $item){
            $arrayList[$i] = array();
            $arrayList[$i]['employee_name'] = $item->absence->employee->name;
            $arrayList[$i]['email'] = $item->absence->employee->email;

//            $currentTime = date('Y-m-d H:m:s');
//            $timeBeforeTwoWeek = strtotime($currentTime) - 2*7*24*60*60;
//            $timeBeforeTwoWeek = date('Y-m-d H:m:s', $timeBeforeTwoWeek);
//            $projects = Process::select('processes.project_id', 'projects.name')
//                ->join('projects', 'projects.id', '=', 'processes.project_id')
//                ->where('processes.employee_id', '=', $po_id)
//                ->where('processes.role_id', '=', $idPO)
//                ->where('processes.delete_flag', '=', '0')
//                ->where('processes.start_date', '<=', $currentTime)
//                ->where('processes.end_date', '>=', $timeBeforeTwoWeek)
//                ->get();
//            foreach ($projects as $project){
//                $processes = Process::where('project_id', '=', $project->project_id)
//                    ->where('delete_flag', '=', 0)
//                    ->where('employee_id', '=', $item->absence->employee->id)
//                    ->get();
//                if($processes->isNotEmpty()) {
//                    $arrayList[$i]['project'] = $project->name;
//                    break;
//                }
//            }
//            if(!isset($arrayList[$i]['project'])) $arrayList[$i]['project'] = '-';

            if(isset($item->project)){
                $arrayList[$i]['project'] = $item->project->name;
            } else {
                $arrayList[$i]['project'] = '-';
            }
            $arrayList[$i]['from_date'] = $item->absence->from_date;
            $arrayList[$i]['to_date'] = $item->absence->to_date;
            $arrayList[$i]['absence_type'] = trans('absence_po.list_po.type.'.$item->absence->absenceType->name );
            $arrayList[$i]['reason'] = $item->absence->reason;
            if($item->absence_status_id === $idWaiting){
                if($item->absence->is_deny === 0) {
                    $arrayList[$i]['description'] = trans('absence.confirmation.absence_request');
                } else if($item->absence->is_deny === 1) {
                    $arrayList[$i]['description'] = trans('absence.confirmation.cancel_request');
                }
            } else {
                $arrayList[$i]['description'] = '-';
            }
            $arrayList[$i]['status'] = trans('absence_po.list_po.status.'.$item->absenceStatus->name );

            if(isset($item->reason)) {
                $arrayList[$i]['reject_reason'] = $item->reason;
            } else {
                $arrayList[$i]['reject_reason'] = '-';
            }
            $i++;
        }
        return collect($arrayList);
    }
    public static function beforeExport(BeforeExport $event)
    {
        //
    }

    public static function beforeWriting(BeforeWriting $event)
    {
        //
    }

    public static function beforeSheet(BeforeSheet $event)
    {
        //
    }

    public static function afterSheet(AfterSheet $event)
    {
        //
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            trans('absence.confirmation.employee_name'),
            trans('absence.confirmation.email'),
            trans('absence.confirmation.project_name'),
            trans('absence.confirmation.from'),
            trans('absence.confirmation.to'),
            trans('absence.confirmation.type'),
            trans('absence.confirmation.cause'),
            trans('absence.confirmation.description'),
            trans('absence.confirmation.status'),
            trans('absence.confirmation.reject_cause')
        ];
    }

}