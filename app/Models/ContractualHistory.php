<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $employee_id
 * @property int $contractual_type_id
 * @property string $start_date
 * @property string $last_updated_at
 * @property string $created_at
 * @property string $delete_flag
 * @property Employee[] $employees
 */
class ContractualType extends Model
{
    /**
     * @var array
     */

    public $table = 'contractual_history';
    protected $fillable = [
        'id',
        'employee_id',
        'contractual_type_id',
        'updated_at','created_at', 'delete_flag'];

    // relationship
}
