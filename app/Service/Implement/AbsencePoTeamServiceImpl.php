<?php
/**
 * Created by PhpStorm.
 * User: Ngoc Quy
 * Date: 6/21/2018
 * Time: 1:35 PM
 */

namespace App\Service\Implement;


use App\Models\Confirm;
use App\Service\AbsencePoTeamService;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AbsencePoTeamServiceImpl implements AbsencePoTeamService
{
    public function poTeamAcceptOrDenyAbsence(Request $request)
    {
        $idReturn = $request['id'];
        if ($request->ajax()) {
            try {
                DB::beginTransaction();
                $confirmChoose = Confirm::where('id', $request['id'])->first();
                $confirmChoose['reason'] = $request['reason'];
                $confirmChoose['absence_status_id'] = 3;
                $confirmChoose->save();
                DB::commit();
            } catch (Exception $ex) {
                DB::rollBack();
                session()->flash(trans('team.msg_fails'), trans('project.msg_content.msg_add_error'));
            } finally {
                if ($request['is_deny'] == 0) {
                    $msgDoneAbsence = trans('absence_po.list_po.status.no_accepted_done');
                    return response(['msg' => 'Product deleted', 'status' => 'success', 'id' => $idReturn, 'deny' => $request['is_deny'], 'html' => $msgDoneAbsence]);
                } elseif ($request['is_deny'] == 1) {
                    $msgDoneDeny = trans('absence_po.list_po.status.accepted_done');
                    return response(['msg' => 'Product deleted', 'status' => 'success', 'id' => $idReturn, 'deny' => $request['is_deny'], 'html' => $msgDoneDeny]);
                } else {
                    return response(['msg' => 'Product deleted', 'status' => 'success', 'id' => $idReturn, 'deny' => $request['is_deny'], 'html' => '-']);
                }
            }
        }
        return response(['msg' => 'Failed deleting the product', 'status' => 'failed']);
    }

    public function poTeamAcceptAbsenceForm(Request $request)
    {
        //absence_status_id: 1=waiting, 2=accepted , 3: rejected
        $idReturn = $request['id'];
        if ($request->ajax()) {
            try {
                DB::beginTransaction();
                $confirmChoose = Confirm::where('id', $request['id'])->first();
                $confirmChoose['absence_status_id'] = 2;
                $confirmChoose->save();
                DB::commit();
            } catch (Exception $ex) {
                DB::rollBack();
                session()->flash(trans('team.msg_fails'), trans('project.msg_content.msg_add_error'));
            } finally {
                if ($request['is_deny'] == 0) {
                    $msgDoneAbsence = '<div class="div confirm-status">' . trans('absence_po.list_po.status.accepted_done') . '</div>';
                    return response(['msg' => 'Product deleted', 'status' => 'success', 'id' => $idReturn, 'absenceStatus' => $msgDoneAbsence, 'html' => '-']);
                } elseif ($request['is_deny'] == 1) {
                    $msgDoneDeny = '<div class="div confirm-status">' . trans('absence_po.list_po.status.no_accepted_done') . '</div>';
                    return response(['msg' => 'Product deleted', 'status' => 'success', 'id' => $idReturn, 'absenceStatus' => $msgDoneDeny, 'html' => '-']);
                } else {
                    return response(['msg' => 'Product deleted', 'status' => 'success', 'id' => $idReturn, 'absenceStatus' => '-', 'html' => '-']);
                }
            }
        }
        return response(['msg' => 'Failed deleting the product', 'status' => 'failed']);
    }

    public function searchAbsence(Request $request, $idLogged)
    {
        $query = Confirm::where('employee_id', $idLogged);

        if (!isset($this->request['number_record_per_page'])) {
            $this->$request['number_record_per_page'] = config('settings.paginate');
        }

        $id = !empty($request->id) ? $request->id : '';
        $name = !empty($request->name) ? $request->name : '';
        $email = !empty($request->email) ? $request->email : '';
        $type = !empty($request->type) ? $request->type : '';
        $startDateForm = !is_null($request->start_date) ? $request->start_date : '';
        $elementStartDate = date_create($startDateForm);
        $startDate = date_format($elementStartDate, 'Y-m-d H:i:s');

        $end_date = !empty($request->end_date) ? $request->end_date : '';
        $elementEndDate = date_create($end_date);
        $endDate = date_format($elementEndDate, 'Y-m-d H:i:s');

        $absence_status = !empty($request->absence_status) ? $request->absence_status : '';

        if (!is_null($request['name'])) {
            $query
                ->whereHas('absence', function ($query) use ($name) {
                    $query->whereHas('employee', function ($query) use ($name) {
                        $query->where("name", 'like', '%' . $name . '%');
                    });
                });
        }
        if (!is_null($request['email'])) {
            $query
                ->whereHas('absence', function ($query) use ($email) {
                    $query->whereHas('employee', function ($query) use ($email) {
                        $query->where("email", 'like', '%' . $email . '%');
                    });
                });
        }
        if (!is_null($request['type'])) {
            $query
                ->whereHas('absence', function ($query) use ($type) {
                    $query->whereHas('absenceType', function ($query) use ($type) {
                        $query->where("name", 'like', '%' . $type . '%');
                    });
                });
        }
        if (!is_null($request['start_date']) &&  !is_null($request['end_date'])) {

            $query
                ->whereHas('absence', function ($query) use ($startDate, $endDate) {
                    $query->where("from_date", '>=', $startDate)
                        ->where("to_date", '<=', $endDate);
                });
        }
        elseif (!is_null($request['start_date'])){
            $query
                ->whereHas('absence', function ($query) use ($startDate) {
                    $query->where("from_date", '>=', $startDate);
                });
        }
        elseif (!is_null($request['end_date'])){
            $query
                ->whereHas('absence', function ($query) use ( $endDate) {
                    $query->where("to_date", '<=', $endDate);
                });
        }

        if (!is_null($request['absence_status'])) {
            $query
                ->whereHas('absenceStatus', function ($query) use ($absence_status) {
                    $query->where("name", 'like', '%' . $absence_status . '%');
                });
        }
        return $query;
    }
}