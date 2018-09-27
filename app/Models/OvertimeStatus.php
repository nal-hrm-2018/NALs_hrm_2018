<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OvertimeStatus extends Model
{
    public $table = 'overtime_statuses';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'name',
        'is_accept',
    ];
}
