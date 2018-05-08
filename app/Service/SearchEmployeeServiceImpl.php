<?php
/**
 * Created by PhpStorm.
 * User: Ngoc Quy
 * Date: 4/23/2018
 * Time: 9:28 AM
 */

namespace App\Service;

use App\Models\Employee;
use Illuminate\Http\Request;

class SearchEmployeeServiceImpl extends CommonService implements SearchEmployeeService
{

    public function searchEmployee(Request $request)
    {
        $query = Employee::query();

        $query->with(['team', 'role']);


        $params['search'] = [
            'id' => !empty($request->id) ? $request->id : '',
            'name' => !empty($request->name) ? $request->name : '',
            'team' => !empty($request->team) ? $request->team : '',
            'email' => !empty($request->email) ? $request->email : '',
            'role' => !empty($request->role) ? $request->role : '',
            'status' => !empty($request->status) ? $request->status : '',
        ];
        foreach ($params as $key => $value){
            $id = $value['id'];
            $name = $value['name'];
            $team = $value['team'];
            $role = $value['role'];
            $email = $value['email'];
            $status = $value['status'];
        }
        if (!empty($role)) {
            $query
                ->whereHas('role', function ($query) use ($role) {
                    $query->where("name", 'like', '%' . $role . '%');
                });
        }
        if (!empty($name)) {
            $query->Where('name', 'like', '%' . $name . '%');
        }
        if (!empty($id)) {
            $query->Where('id', '=', $id);
        }
        if (!empty($team)) {
            $query
                ->whereHas('team', function ($query) use ($team) {
                    $query->where("name", 'like', '%' . $team. '%');
                });
        }
        if (!empty($email)) {
            $query->Where('email', 'like', '%' . $email . '%');
        }
        if (!empty($status)) {
            switch ($status){
                case "Unactive":
                    $query->Where('work_status', '=', '1');
                    break;
                case "Active":
                    $query->Where('work_status', '=', '0');
                    break;
            }
        }
        $employeesSearch = $query
            ->where('delete_flag','=',0);

        return $employeesSearch;
    }
}