<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use App\User;
use App\Models\Role;
use JWTAuth;
use JWTAuthException;
use Hash;
//use Illuminate\Support\Collection;
//use App\Http\Resources\UserCollection as UserResource;

class ProfileController extends BaseAPIController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = JWTAuth::toUser($request->token);
        $role_id = $user->role_id;
        $role_name = Role::where('id', $role_id)->value('name');
        $gender_id = $user->role_id;
        if ($gender_id == 1) {
            $gender_name = 'female';
        }elseif ($gender_id == 2) {
            $gender_name = 'male';
        }else{
            $gender_name = 'N/A';
        }
        $data = [
            'id' => $user->id,
            'email'=>$user->email,
            'name' => $user->name,
            'birthday' => $user->birthday,
            'gender' => [
                'gender_id' => $gender_id,
                'gender_name' => $gender_name
            ],
            'mobile' => $user->mobile,
            'address' => $user->address,
            'marital_status'=> $user->marital_status,
            'startwork_date' => $user->startwork_date,
            'endwork_date' => $user->endwork_date,
            'role' => [
                'role_id' => $role_id,
                'role_name' => $role_name
            ],
            ];
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
        //
    }
}
