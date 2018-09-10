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
class TempListConfirm extends Model
{
    /**
     * @var array
     */

    public $table = 'temp_list_confirm';
    protected $fillable = [
        'employee_id',
        'absence_type_id',
        'absence_time_id',
        'absence_id',
        'reason',
        'project_id',
        'last_updated_at', 'last_updated_by_employee', 'created_at', 'created_by_employee', 'delete_flag'
    ];

    public function absence()
    {
        return $this->belongsTo('App\Models\Absence','absence_id');
    }
    public function employee()
    {
        return $this->belongsTo('App\Models\Employee','employee_id');
    }
    public function absenceType()
    {
        return $this->belongsTo('App\Models\AbsenceType','absence_type_id');
    }
    public function absenceTime()
    {
        return $this->belongsTo('App\Models\AbsenceTime','absence_time_id');
    }
    public function project()
    {
        return $this->belongsTo('App\Models\Project','project_id');
    }

}
