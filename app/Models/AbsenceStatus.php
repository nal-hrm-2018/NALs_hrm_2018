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
class AbsenceStatus extends Model
{
    /**
     * @var array
     */

    public $table = 'absence_statuses';
    protected $fillable = [
        'id',
        'name',
        'description',
        'updated_at', 'updated_by_employee', 'created_at', 'created_by_employee', 'delete_flag'];

    public function absences()
    {
        return $this->hasMany('App\Models\Absence', 'absence_status_id')->where('delete_flag', '=', 0);
    }

}
