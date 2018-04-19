<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $id
 * @property string $name
 * @property float $income
 * @property float $real_cost
 * @property string $description
 * @property string $status
 * @property string $start_date
 * @property string $end_date
 * @property string $last_updated_at
 * @property int $last_updated_by_employee
 * @property string $created_at
 * @property int $created_by_employee
 * @property string $delete_flag
 * @property Process[] $processes
 */
class Project extends Model
{
    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['name', 'income', 'real_cost', 'description', 'status', 'start_date', 'end_date', 'last_updated_at', 'last_updated_by_employee', 'created_at', 'created_by_employee', 'delete_flag'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function processes()
    {
        return $this->hasMany('App\Models\Processe', 'projects_id');
    }

    public function roles()
    {
        return $this->belongsToMany(
            'App\Models\Role',
            'processes',
            'projects_id',
            'role_id');
    }
}
