<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Overtime extends Model
{
    public $table = 'overtime';
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
}
