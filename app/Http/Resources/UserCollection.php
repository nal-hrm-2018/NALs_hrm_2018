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
        // return parent::toArray($request);
        // return [
        //     'data' => $this->collection,
        //     'response' => [
        //         'status' => 'success',
        //         'code' => 200
        //     ],
        // ];
        // return [
        //     'id' => $this->id,
        //     'name' => $this->name,
        //     'email' => $this->email,
        //     'posts' => Post::collection($this->posts),
        //     'status' => 'success'
        // ];

        // $this->collection->transform(function (User $user) {
        //     return (new UserResource($user));
        // });

        // return parent::toArray($request);
    }
}
