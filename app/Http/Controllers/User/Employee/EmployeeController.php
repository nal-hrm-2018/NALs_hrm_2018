<?php
/**
 * Created by PhpStorm.
 * User: Ngoc Quy
 * Date: 4/16/2018
 * Time: 11:26 AM
 */

namespace App\Http\Controllers\User\Employee;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmployeeController extends Controller
{
    public function index()
    {
        $dataAllEmployees = Employee::all();
        return view('employee.list')->with("employees",$dataAllEmployees);
//        compact('dataAllEmployees','id')
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

    public function destroy(Employee $employee)
    {
        //
    }
    public function searchCommonInList(Request $request, $id){

    }
}