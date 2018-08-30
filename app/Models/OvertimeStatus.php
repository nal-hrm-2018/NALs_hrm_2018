<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OvertimeStatus extends Model
{
    public $table = 'overtime_statuses';
    protected $fillable = [
        'id',
        'name',
    ];
}
