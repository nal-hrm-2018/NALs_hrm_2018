<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\employees;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;

use App\Models\Role;
use JWTAuth;
use JWTAuthException;
use Hash;

class ListEmployeeController extends BaseAPIController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $employees = Employee::all();


        // $employees = JWTAuth::toemployees($request->token);
        // $employee_id = $employees->id;
        // $view_list_employees_id = Permissions::where('name', 'view_list_employees');
        // $permissions = PermissionEmployee::select('permission_id')
        //     ->where('employee_id', $employee_id)->where('employee_id',$view_list_employees_id);
        //     $employees->employeesId,['getid' => $employees->employeesNo]

        // $employees = employees::all();

        foreach ($employees as $employees){
           $data[] = [
                'id' => $employees->id,
                'email'=>$employees->email,
                'name' => $employees->name,
                'birthday' => $employees->birthday,
                'gender' => $employees->gender,
                'mobile' => $employees->mobile,
                'address' => $employees->address,
                'marital_status'=> $employees->marital_status,
                'startwork_date' => $employees->startwork_date,
                'endwork_date' => $employees->endwork_date,
                'role_id' => $employees->role_id
                ];

        }
        return $this->sendSuccess($data, 'employee profile');
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show(Request $request)
    {
      
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
