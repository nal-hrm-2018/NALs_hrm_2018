<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;
/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $last_updated_at
 * @property int $last_updated_by_employee
 * @property string $created_at
 * @property int $created_by_employee
 * @property string $delete_flag
 * @property Employee[] $employees
 */
class Permissions extends Model
{
    /**
     * @var array
     */

    public $table = 'permissions';
    protected $fillable = ['name', 'description', 'last_updated_at', 'last_updated_by_employee', 'created_at', 'created_by_employee', 'delete_flag'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function employees()
    {
        return $this->belongsToMany('App\Models\Employee', 'permission_employee', 'permission_id', 'employee_id');
    }
}
