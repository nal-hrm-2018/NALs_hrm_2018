<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Overtime extends Model
{
    public $table = 'overtime';
    public $timestamps = true;
    protected $fillable = [
        'id',
        'employee_id',
        'project_id',
        'reason',
        'date',
        'start_time',
        'end_time',
        'overtime_type_id',
        'overtime_status_id',
        'total_time',
        'correct_total_time'
    ];
    protected $casts = [
        'date' => 'date',
        'startwork_date' => 'date'
    ];
    public function status()
    {
        return $this->belongsTo('App\Models\OvertimeStatus', 'overtime_status_id');
    }
    public function type()
    {
        return $this->belongsTo('App\Models\OvertimeType', 'overtime_type_id');
    }
    public function project()
    {
        return $this->belongsTo('App\Models\Project','project_id');
    }
    public function employee()
    {
        return $this->belongsTo('App\Models\Employee', 'employee_id');
    }
}
