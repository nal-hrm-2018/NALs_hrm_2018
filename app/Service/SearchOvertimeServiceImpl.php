<?php
/**
 * Created by PhpStorm.
 * User: Ngoc Quy
 * Date: 4/23/2018
 * Time: 9:28 AM
 */

namespace App\Service;

use App\Models\Overtime;
use Illuminate\Http\Request;

class SearchOvertimeServiceImpl extends CommonService implements SearchOvertimeService
{

    public function searchOvertime(Request $request)
    {
        $query = Overtime::all();

//         $params['search'] = [
//             'id' => !empty($request->id) ? $request->id : '',
//             'name' => !empty($request->name) ? $request->name : '',
//             'team' => !empty($request->team) ? $request->team : '',
//             'email' => !empty($request->email) ? $request->email : '',
//             'role' => !empty($request->role) ? $request->role : '',
//         ];
//         foreach ($params as $key => $value) {
//             $id = $value['id'];
//             $name = $value['name'];
//             $team = $value['team'];
//             $role = $value['role'];
//             $email = $value['email'];
//         }
//         if (!empty($role)) {
//             $query
//                 ->whereHas('role', function ($query) use ($role) {
//                     $query->where("name",$role);
//                 });
//         }
//         if (!empty($name)) {
//             $query->Where('name', 'like', '%' . $name . '%');
//         }

//         if (!is_null($request['is_employee'])) {
//             $query->Where('is_employee', $request['is_employee']);
//         }

//         if (!empty($request['role_in_process'])) {
//             $role_in_process= $request['role_in_process'];
//             $query
//                 ->whereHas('processes', function ($query) use ( $role_in_process ) {
//                     $query->where("role_id", $role_in_process);
//                 });
//         }

//         if (!empty($request['company'])) {
//             $query->Where('company', 'like', '%' . $request['company'] . '%');
//         }

//         if (!empty($id)) {
//             $query->Where('id', '=', $id);
//         }
//         if (!empty($team)) {
//             $query
//                 ->whereHas('teams', function ($query) use ($team) {
//                     $query->where("name", 'like', '%' . $team . '%');
//                 });
//         }

//         if (!empty($email)) {
//             $query->Where('email', 'like', '%' . $email . '%');
//         }

//         if (!is_null($request['status'])) {
//             $dateNow = date('Y-m-d');
//             if($request['status'] == 0){
//                 $query->Where('work_status', $request['status'])
//                     ->where('endwork_date','>=',$dateNow);
//             }
//             if ($request['status'] == 1){
//                 $query->Where('work_status', $request['status']);
//             }
//             if ($request['status'] == 2){
//                 $query->Where('work_status', '0')
//                     ->where('endwork_date','<',$dateNow);
//             }
//         }
//         if(!empty($request['year_absence'])){
//             $year=$request['year_absence'];
//             $query->whereYear('endwork_date','>=',$year);
//         }
//         $date_ot = $request['date_ot'];
//         if (!empty($date_ot)) {
//             $query
//                 ->whereHas('overtime', function ($query) use ($date_ot) {
//                     $query->where("date", 'like', '%' . $date_ot . '%');
//                 });
//         }
//         $date_ot = $request['year_ot'];
//         if (!empty($date_ot)) {
//             $query
//                 ->whereHas('overtime', function ($query) use ($date_ot) {
//                     $query->whereYear("date", 'like', '%' . $date_ot . '%');
//                 });
//         }
//         $date_ot =$request['month_ot'];
//         if (!empty($date_ot)) {
//             $query
//                 ->whereHas('overtime', function ($query) use ($date_ot) {
//                     $query->whereMonth('date','=',$date_ot);
//                 });
//         }
//         $employeesSearch = $query
//             ->where('delete_flag', '=', 0);
        return $employeesSearch;
    }
}