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
        'projects_id',
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
        return $this->hasMany('App\Models\Performance', 'process_id');
    }
}
