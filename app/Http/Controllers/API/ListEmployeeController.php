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
        $user = JWTAuth::toUser($request->token);
        if($user->hasPermission("view_list_employee")) {
            $employees = Employee::all();
            foreach ($employees as $employees){
                $role_id = $employees->role_id;
                $role_name = Role::where('id', $role_id)->value('name');
                $gender_id = $employees->role_id;
                if ($gender_id == 1) {
                    $gender_name = 'female';
                }elseif ($gender_id == 2) {
                    $gender_name = 'male';
                }else{
                    $gender_name = 'N/A';
                }
               $data[] = [
                    'id' => $employees->id,
                    'email'=>$employees->email,
                    'name' => $employees->name,
                    'birthday' => $employees->birthday,
                    'gender' => [
                        'gender_id' => $gender_id,
                        'gender_name' => $gender_name
                    ],
                    'mobile' => $employees->mobile,
                    'address' => $employees->address,
                    'marital_status'=> $employees->marital_status,
                    'startwork_date' => $employees->startwork_date,
                    'endwork_date' => $employees->endwork_date,
                    'role' => [
                        'role_id' => $role_id,
                        'role_name' => $role_name
                    ],
                ];
            }
            return $this->sendSuccess($data, 'list employees');
        }        
        else{
            return $this->sendError(410, 'denied');
        }
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
