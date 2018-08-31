<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Process extends Model
{
    protected $table = 'processes';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'employee_id',
        'project_id',
        'role_id',
        'check_project_exit',
        'man_power',
        'start_date',
        'end_date',
        'last_updated_at',
        'last_updated_by_employee',
        'created_at',
        'created_by_employee',
        'delete_flag'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function employee()
    {
        return $this->belongsTo('App\Models\Employee','employee_id');
    }

    public function project()
    {
        return $this->belongsTo('App\Models\Project','project_id');
    }

    public function role()
    {
        return $this->belongsTo('App\Models\Role','role_id');
    }
    public function performances()
    {
        return $this->hasMany('App\Models\Performance', 'process_id')->where('delete_flag', '=', 0);
    }
//    public function overtimes(){
//        return $this->hasMany('App\Models\Overtime','process_id');
//    }
}
