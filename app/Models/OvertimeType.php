<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OvertimeType extends Model
{
    public $table = 'overtime_types';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'name',
    ];
}
