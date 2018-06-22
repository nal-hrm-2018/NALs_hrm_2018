<?php
/**
 * Created by PhpStorm.
 * User: Ngoc Quy
 * Date: 6/19/2018
 * Time: 1:18 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Holiday extends  Model
{

    public $table = 'holidays';
    protected $fillable = [
        'id',
        'date',
        'description',
        'updated_at', 'updated_by_employee', 'created_at', 'created_by_employee', 'delete_flag'
    ];
}