<?php
/**
 * Created by PhpStorm.
 * User: Ngoc Quy
 * Date: 6/19/2018
 * Time: 1:18 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class HolidayDefault extends  Model
{

    public $table = 'holidays_default';
    protected $fillable = [
        'id',
        'name',
        'date',
        'description',
        'holiday_status_id',
        'updated_at', 'updated_by_employee', 'created_at', 'created_by_employee', 'delete_flag'
    ];

    protected $casts = [
        'date' => 'date'
    ];

    public function status()
    {
        return $this->belongsTo('App\Models\HolidayStatus', 'holiday_status_id');
    }
}