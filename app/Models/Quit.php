<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quit extends Model
{
    public $table = 'quit';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'employee_id',
        'reason',
        'quit_date',
    ];

    public function employee(){
        return $this->belongsTo('App\Models\Employee', 'employee_id');
    }
}
