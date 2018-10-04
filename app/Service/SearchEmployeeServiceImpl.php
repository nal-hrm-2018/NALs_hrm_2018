<?php
/**
 * Created by PhpStorm.
 * User: Ngoc Quy
 * Date: 4/23/2018
 * Time: 9:28 AM
 */

namespace App\Service;

use App\Models\Employee;
use \App\Models\Overtime;
use Illuminate\Http\Request;

class SearchEmployeeServiceImpl extends CommonService implements SearchEmployeeService
{

    public function searchEmployee(Request $request)
    {
        // dd($request->name);
        $query = Employee::query();

//        $query->with(['team', 'role']);

        $params['search'] = [
            'id' => !empty($request->id) ? $request->id : '',
            'name' => !empty($request->name) ? $request->name : '',
            'team' => !empty($request->team) ? $request->team : '',
            'email' => !empty($request->email) ? $request->email : '',
            'role' => !empty($request->role) ? $request->role : '',
        ];
        foreach ($params as $key => $value) {
            $id = (string)$value['id'];
            $name = $value['name'];
            $team = $value['team'];
            $role = $value['role'];
            $email = $value['email'];
        }
        if (!empty($role)) {
            $query
                ->whereHas('role', function ($query) use ($role) {
                    $query->where("name",$role);
                });
        }
        if (!empty($name)) {
            $query->Where('name', 'like', '%' . $name . '%');
        }
        if (!is_null($request['is_employee'])) {
            $query->Where('is_employee', $request['is_employee']);
        }

        if (!empty($request['role_in_process'])) {
            $role_in_process= $request['role_in_process'];
            $query
                ->whereHas('processes', function ($query) use ( $role_in_process ) {
                    $query->where("role_id", $role_in_process);
                });
        }

        if (!empty($request['company'])) {
            $query->Where('company', 'like', '%' . $request['company'] . '%');
        }
        
        if (!empty($id)) {
            $query->Where('id', 'like', $id);
        }
        
        if (!empty($team)) {
            $query
                ->whereHas('teams', function ($query) use ($team) {
                    $query->where("name", 'like', '%' . $team . '%');
                });
        }

        if (!empty($email)) {
            $query->Where('email', 'like', '%' . $email . '%');
        }

        // if (!is_null($request['status'])) {
        //     $dateNow = date('Y-m-d');
        //     if($request['status'] == 0){
        //         $query->Where('work_status', $request['status'])
        //             ->where('endwork_date','>=',$dateNow);
        //     }
        //     if ($request['status'] == 1){
        //         $query->Where('work_status', $request['status']);
        //     }
        //     if ($request['status'] == 2){
        //         $query->Where('work_status', '0')
        //             ->where('endwork_date','<',$dateNow);
        //     }
        // }
        // if(!empty($request['year_absence'])){
        //     $year=$request['year_absence'];
        //     $query->whereYear('endwork_date','>=',$year);
        // }
        if (!empty($request['project_id'])) {
        $project = $request['project_id'];
        $query
            ->whereHas('processes', function ($query) use ($project) {
                $query->where("project_id",$project);
            });
        }
        $month_quit=$request['month_quit'];

        // if (!empty($month_quit)) {
        //     $query->whereMonth("endwork_date",'=',$month_quit);
        // }
        // $year_quit=$request['year_quit'];
        // if (!empty($year_quit)) {
        //     $query->whereYear("endwork_date",'=',$year_quit);
        // }
        // $query->with(['contractualHistory' => function ($query) {
        //         $query->orderBy('end_date', 'desc')->first();
        //     }]);
        
        $employeesSearch = $query
            ->where('delete_flag', '=', 0);
        return $employeesSearch;
    }
    public function searchOvertime(Request $request)
    {       
        $number_record_per_page = !empty($request->number_record_per_page) ? $request->number_record_per_page : '';
        $name = !empty($request->name) ? $request->name : '';
        $type = !empty($request->type) ? $request->type : '';
        $status = !empty($request->status) ? $request->status : '';
        $from_date = !empty($request->from_date) ? $request->from_date : '';
        $to_date = !empty($request->to_date) ? $request->to_date : '';
        $user_id = !empty($request->user_id) ? $request->user_id : '';
        $oldmonth = !empty($request->oldmonth) ? $request->oldmonth : '';
        $query = Overtime::with('status', 'type', 'process.project', 'employee');
        // dd($query->get()->toArray());
        $query->where('delete_flag', '=', 0);
        $query->Where('employee_id', '=', $user_id);

        if (!empty($name)) {
            $query->whereHas('process', function ($query) use ($name) {
                $query->whereHas('project', function ($query) use ($name) {
                    $query->where("name", 'like', '%' . $name . '%');
                });
            });
        }
        if (!empty($type)) {
            $query->whereHas('type', function ($query) use ($type) {
                $query->where("name", $type);
            });
        }
        if (!empty($status)) {
            $query->whereHas('status', function ($query) use ($status) {
                $query->where("name", $status);
            });
        }
        if (!empty($from_date) && !empty($to_date)) {
            $query->whereBetween('date', [$from_date, $to_date]);
        }
        if (!empty($from_date) && empty($to_date)) {
            $query->where('date', '>=', $from_date);
        }
        if (empty($from_date) && !empty($to_date)) {
            $query->where('date', '<=', $to_date);
        }
        
        $employeesSearch = $query->orderBy('updated_at', 'desc');;
            
        return $employeesSearch;
    }
    public function searchOvertimePO(Request $request)
    {       
        $number_record_per_page = !empty($request->number_record_per_page) ? $request->number_record_per_page : '';
        $name = !empty($request->name) ? $request->name : '';
        $type = !empty($request->type) ? $request->type : '';
        $status = !empty($request->status) ? $request->status : '';
        $from_date = !empty($request->from_date) ? $request->from_date : '';
        $to_date = !empty($request->to_date) ? $request->to_date : '';
        $user_id = !empty($request->user_id) ? $request->user_id : '';
        $oldmonth = !empty($request->oldmonth) ? $request->oldmonth : '';
        $query = Overtime::with('status', 'type', 'process.project', 'employee');
        $query->where('delete_flag', '=', 0);

        $query->where(function ($query) use ($request) {
            $query->whereIn('process_id', $request->process_dev_id);
            if ($request->is_manager) {
                $query->orWhere('process_id', null);
            }
        });
        
        if (!empty($name)) {
            $query->whereHas('process', function ($query) use ($name) {
                $query->whereHas('project', function ($query) use ($name) {
                    $query->where("name", 'like', '%' . $name . '%');
                });
            });
        }
        if (!empty($type)) {
            $query->whereHas('type', function ($query) use ($type) {
                $query->where("name", $type);
            });
        }
        if (!empty($status)) {
            $query->whereHas('status', function ($query) use ($status) {
                $query->where("name", $status);
            });
        }
        if (!empty($from_date) && !empty($to_date)) {
            $query->whereBetween('date', [$from_date, $to_date]);
        }
        if (!empty($from_date) && empty($to_date)) {
            $query->where('date', '>=', $from_date);
        }
        if (empty($from_date) && !empty($to_date)) {
            $query->where('date', '<=', $to_date);
        }
        if(empty($number_record_per_page)){
            $query->where('date', '>', $oldmonth);
        }

        $overtimeSearch = $query->orderBy('updated_at', 'desc');
        // dd($query->get()->toArray());
        return $overtimeSearch;
    }
}