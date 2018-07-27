<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
       return  [
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
           // 'role' => Role::collection($user->role_id)
            ];
    }
}
