<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Overtime extends Model
{
    public $table = 'overtime';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'employee_id',
        'date',
        'start_time',
        'end_time',
        'total_time',
        'overtime_type_id',
        'overtime_status_id',
        'reason'
    ];
    protected $casts = [
        'date' => 'date',
    ];
    public function status()
    {
        return $this->belongsTo('App\Models\OvertimeStatus', 'overtime_status_id');
    }
    public function type()
    {
        return $this->belongsTo('App\Models\OvertimeType', 'overtime_type_id');
    }
    public function process()
    {
        return $this->belongsTo('App\Models\Process', 'process_id');
    }
    public function employee()
    {
        return $this->belongsTo('App\Models\EMployee', 'employee_id');
    }
}
