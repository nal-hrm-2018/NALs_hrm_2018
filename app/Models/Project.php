<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = [
        'id',
        'name',
        'income',
        'real_cost',
        'description',
        'status',
        'start_date',
        'end_date',
        'last_updated_at',
        'last_updated_by_employee',
        'created_at',
        'created_by_employee',
        'delete_flag'
    ];

    public function employees(){
        return $this->belongsToMany('App\Models\Employee', 'processes','projects_id', 'employee_id')
            ->withPivot('id', 'man_power', 'start_date', 'end_date', 'employee_id', 'projects_id', 'role_id');
    }
    public function processes(){
        return $this->hasMany('App\Models\Process', 'projects_id');
    }
}
