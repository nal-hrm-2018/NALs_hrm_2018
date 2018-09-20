<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeTeam extends Model
{
    protected $table = 'employee_team';

    public $timestamps = false;

    protected $fillable = [
        'employee_id',
        'team_id'
    ];
}
