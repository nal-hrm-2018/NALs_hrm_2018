<?php
/**
 * Created by PhpStorm.
 * User: Ngoc Quy
 * Date: 6/25/2018
 * Time: 10:03 AM
 */

namespace App\Export;


use App\Models\AbsenceStatus;
use App\Models\Confirm;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AbsencePOTeam implements FromCollection, WithHeadings
{
    private $request;

    public function __construct(Request $request){
        $this->request = $request;
    }

    /**
     * @return Collection
     */
    public function collection()
    {
        $idLogged = Auth::id();
        $query = Confirm::where('employee_id', $idLogged)->where('delete_flag','0');

        if (!isset($this->request['number_record_per_page'])) {
            $this->request['number_record_per_page'] = config('settings.paginate');
        }

        $id = !empty($this->request->id) ? $this->request->id : '';
        $name = !empty($this->request->name) ? $this->request->name : '';
        $email = !empty($this->request->email) ? $this->request->email : '';
        $type = !empty($this->request->type) ? $this->request->type : '';
        $startDateForm = !is_null($this->request->start_date) ? $this->request->start_date : '';
        $elementStartDate = date_create($startDateForm);
        $startDate = date_format($elementStartDate, 'Y-m-d H:i:s');

        $end_date = !empty($this->request->end_date) ? $this->request->end_date : '';
        $elementEndDate = date_create($end_date);
        $endDate = date_format($elementEndDate, 'Y-m-d H:i:s');

        $absence_status = !empty($this->request->absence_status) ? $this->request->absence_status : '';

        if (!is_null($this->request['name'])) {
            $query
                ->whereHas('absence', function ($query) use ($name) {
                    $query->whereHas('employee', function ($query) use ($name) {
                        $query->where("name", 'like', '%' . $name . '%');
                    });
                });
        }
        if (!is_null($this->request['email'])) {
            $query
                ->whereHas('absence', function ($query) use ($email) {
                    $query
                        ->whereHas('employee', function ($query) use ($email) {
                        $query->where("email", 'like', '%' . $email . '%');
                    });
                });
        }
        if (!is_null($this->request['type'])) {
            $query
                ->whereHas('absence', function ($query) use ($type) {
                    $query->whereHas('absenceType', function ($query) use ($type) {
                        $query->where("name", 'like', '%' . $type . '%');
                    });
                });
        }
        if (!is_null($this->request['start_date']) &&  !is_null($this->request['end_date'])) {

            $query
                ->whereHas('absence', function ($query) use ($startDate, $endDate) {
                    $query->where("from_date", '>=', $startDate)
                        ->where("to_date", '<=', $endDate);
                });
        }
        elseif (!is_null($this->request['start_date'])){
            $query
                ->whereHas('absence', function ($query) use ($startDate) {
                    $query->where("from_date", '>=', $startDate);
                });
        }
        elseif (!is_null($this->request['end_date'])){
            $query
                ->whereHas('absence', function ($query) use ( $endDate) {
                    $query->where("to_date", '<=', $endDate);
                });
        }

        if (!is_null($this->request['absence_status'])) {
            $query
                ->whereHas('absenceStatus', function ($query) use ($absence_status) {
                    $query->where("name", 'like', '%' . $absence_status . '%');
                });
        }
        $arrayList = array();
        $indexInLoop = 0;
        $absenceStatus = AbsenceStatus::all();
        $idAbsenceStatus = $absenceStatus->where('name', '=', 'waiting')->first()->id;
        $dataConfirmQuery = $query
                            ->orderBy('id', 'DESC')
                            ->paginate($this->request['number_record_per_page']);
        foreach ($dataConfirmQuery as $item){
            $arrayList[$indexInLoop] = array();
            $arrayList[$indexInLoop]['employee_name'] = $item->absence->employee->name;
            $arrayList[$indexInLoop]['email'] = $item->absence->employee->email;
            $arrayList[$indexInLoop]['from_date'] = $item->absence->from_date;
            $arrayList[$indexInLoop]['to_date'] = $item->absence->to_date;
            $arrayList[$indexInLoop]['absence_type']= trans('absence_po.list_po.type.'.$item->absence->absenceType->name );;

            if (!is_null($item->absence->reason)){
                $arrayList[$indexInLoop]['reason'] = $item->absence->reason;
            }
            else{
                $arrayList[$indexInLoop]['reason'] = '-';
            }
            if($item->absence_status_id === $idAbsenceStatus){
                if($item->absence->is_deny === 0) {
                    $arrayList[$indexInLoop]['description'] = trans('absence.confirmation.absence_request');
                } else if($item->absence->is_deny === 1) {
                    $arrayList[$indexInLoop]['description'] = trans('absence.confirmation.cancel_request');
                }
            } else {
                $arrayList[$indexInLoop]['description'] = '-';
            }
            $arrayList[$indexInLoop]['status'] = trans('absence_po.list_po.status.'.$item->absenceStatus->name);
            if (!empty($item->reason)){
                $arrayList[$indexInLoop]['reject_reason'] = $item->reason;
            }
            else{
                $arrayList[$indexInLoop]['reject_reason'] = '-';
            }
            $indexInLoop++;
        }
        return collect($arrayList);
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            trans('absence.confirmation.employee_name'),
            trans('absence.confirmation.email'),
            trans('absence.confirmation.from'),
            trans('absence.confirmation.to'),
            trans('absence.confirmation.type'),
            trans('absence.confirmation.cause'),
            trans('absence_po.list_po.profile_info.note'),
            trans('absence.confirmation.status'),
            trans('absence.confirmation.reject_cause')
        ];
    }
}