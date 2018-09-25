<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $last_updated_at
 * @property string $created_at
 * @property int $created_by_employee
 * @property string $delete_flag
 * @property Employee[] $employees
 */
class ContractualType extends Model
{
    /**
     * @var array
     */

    public $table = 'contractual_type';
    protected $fillable = [
        'id',
        'name',
        'description',
        'updated_at', 'updated_by_employee', 'created_at', 'created_by_employee', 'delete_flag'];

    public function employee()
    {
        return $this->hasMany('App\Models\Employee', 'contractual_type_id')->where('delete_flag', '=', 0);
    }

}
