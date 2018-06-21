<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
class Confirm extends Model
{
    /**
     * @var array
     */
    public $table = 'confirms';
    protected $fillable = [
        'employee_id',
        'absence_status_id',
        'absence_id',
        'reason',
        'last_updated_at', 'last_updated_by_employee', 'created_at', 'created_by_employee', 'delete_flag'
        ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */

    public function absence()
    {
        return $this->belongsTo('App\Models\Absence', 'absences_id');
    }

    public function absenceStatus()
    {
        return $this->belongsTo('App\Models\AbsenceStatus', 'absence_status_id');
    }
    public function employee()
    {
        return $this->absence->belongsTo('App\Models\Employee','employees_id');
    }
}
