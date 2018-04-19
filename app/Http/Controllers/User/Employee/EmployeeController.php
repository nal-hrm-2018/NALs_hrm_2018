<?php
/**
 * Created by PhpStorm.
 * User: Ngoc Quy
 * Date: 4/16/2018
 * Time: 11:26 AM
 */

namespace App\Http\Controllers\User\Employee;

use App\Models\Employee;
use App\Models\Team;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::where('delete_flag','=',0)->get();
        return view('employee.list', compact('employees'));
    }

    public function create()
    {
        $dataTeam = Team::select('id','name')->get()->toArray();
        $dataRoles = Role::select('id','name')->get()->toArray();
        $dataEmployeeTypes = Employee_type::select('id','name')->get()->toArray();
        return view('admin.module.employees.add',['dataTeam' => $dataTeam, 'dataRoles' => $dataRoles, 'dataEmployeeTypes' => $dataEmployeeTypes]);
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Employee $employee)
    {
        //
    }

    public function edit(Employee $employee)
    {
        //
    }

    public function update(Request $request, Employee $employee)
    {
        //
    }

    public function destroy($id, Request $request)
    {

        if ( $request->ajax() ) {
            $employees = Employee::where('id',$id)->where('delete_flag',0)->first();
            $employees->delete_flag = 1;
            $employees->save();

            return response(['msg' => 'Product deleted', 'status' => 'success','id'=> $id]);
        }
        return response(['msg' => 'Failed deleting the product', 'status' => 'failed']);
    }
    public function searchCommonInList(Request $request){
        $query = Employee::query();

        $query->with(['team', 'role']);

        if ($request->input('role') != null ){
            $query
                ->whereHas('role', function ($query) use ($request) {
                    $query->where("name", 'like', '%'.$request->input('role').'%');
                });
        }
        if ($request->input('name') != null ){
                    $query->orWhere('name', 'like', '%'.$request->name.'%');
        }
        if ($request->id != null){
                    $query->orWhere('id', '=', $request->id);
        }
        if ($request->team != null) {
            $query
                ->whereHas('team', function ($query) use ($request) {
                    $query->where("name", 'like', '%'.$request->input('team').'%');
                });
        }
        if ($request->email != null) {
            $query->orWhere('email','like','%'.$request->email.'%');
        }
        if ($request->status != null) {
            $query->orWhere('work_status','like','%'.$request->status.'%');
        }
        $employeesSearch = $query->get();
        return view('employee.list')->with("employees", $employeesSearch);
    }
/*
        ALL DEBUG
        echo "<pre>";
        print_r($employees);
        die;
        var_dump(): user in view;
        dd(); view array
*/
}