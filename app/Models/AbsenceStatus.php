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

    public $table = 'absence_status';
    protected $fillable = [
        'name',
        'description',];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */


}
