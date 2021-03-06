<?php
/**
 * Created by PhpStorm.
 * User: Ngoc Quy
 * Date: 6/20/2018
 * Time: 10:39 AM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class DayType extends Model
{
    public $table = 'day_types';
    protected $fillable = [
        'id',
        'name',
        'updated_at', 'updated_by_employee', 'created_at', 'created_by_employee', 'delete_flag'
    ];
    public function holiday()
    {
        return $this->hasOne('App\Models\Holiday');
    }
}