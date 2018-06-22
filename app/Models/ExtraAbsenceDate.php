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
class ExtraAbsenceDate extends Model
{
    /**
     * @var array
     */

    public $table = 'extra_absence_dates';
    protected $fillable = [
        'id',
        'employee_id',
        'year',
        'date',
        'last_updated_at', 'last_updated_by_employee', 'created_at', 'created_by_employee', 'delete_flag'];


    public function employee()
    {
        return $this->belongsTo('App\Models\Employee','employee_id');
    }

}
