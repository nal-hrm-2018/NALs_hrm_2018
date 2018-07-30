<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaritalStatus extends Model
{
    public $table = 'marital_status';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'status'
        // 'last_updated_at',
        // 'last_updated_by_employee',
        // 'created_at',
        // 'created_by_employee',
        // 'delete_flag'
    ];

    public function employees()
    {
        return $this->hasMany('App\Models\Employee');
    }
}
