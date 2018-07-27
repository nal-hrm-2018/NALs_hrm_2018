<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use App\User;

use JWTAuth;
use JWTAuthException;
use Hash;

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

        $data[] = [
                'id' => $user->id,
                'email'=>$user->email,
                'name' => $user->name,
                'birthday' => $user->birthday,
                'gender' => $user->gender,
                'mobile' => $user->mobile,
                'address' => $user->address,
                'marital_status'=> $user->marital_status,
                'startwork_date' => $user->startwork_date,
                'endwork_date' => $user->endwork_date,
                'role_id' => $user->role_id
                ];

     //   $data = new UserCollection($user);
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
