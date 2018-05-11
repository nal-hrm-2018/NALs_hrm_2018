<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public function roles()
{
return $this->hasMany(Employee_type::class)->where('delete_flag', '=', 0);
}
}
