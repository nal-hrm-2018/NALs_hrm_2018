<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $employee_id
 * @property string $projects_id
 * @property int $role_id
 * @property string $check_project_exit
 * @property float $man_power
 * @property string $start_date
 * @property string $end_date
 * @property string $last_updated_at
 * @property int $last_updated_by_employee
 * @property string $created_at
 * @property int $created_by_employee
 * @property string $delete_flag
 * @property Employee $employee
 * @property Project $project
 * @property Role $role
 * @property Performance[] $performances
 */
class Processe extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['employee_id', 'projects_id', 'role_id', 'check_project_exit', 'man_power', 'start_date', 'end_date', 'last_updated_at', 'last_updated_by_employee', 'created_at', 'created_by_employee', 'delete_flag'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function employee()
    {
        return $this->belongsTo('App\Models\Employee');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo('App\Models\Project', 'projects_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function performances()
    {
        return $this->hasMany('App\Models\Performance', 'processes_id');
    }
}
