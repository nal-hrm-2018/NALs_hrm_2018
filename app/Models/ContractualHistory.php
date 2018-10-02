<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $employee_id
 * @property int $contractual_type_id
 * @property string $start_date
 * @property string $created_at
 * @property string $updated_at
 * @property string $delete_flag
 * @property Employee[] $employees
 */
class ContractualHistory extends Model
{
    /**
     * @var array
     */

    public $table = 'contractual_history';
    protected $fillable = [
        'id',
        'employee_id',
        'contractual_type_id',
        'created_at', 'updated_at','start_date', 'end_date', 'delete_flag'];

    public function employee()
    {
        return $this->belongsTo('App\Models\Employee', 'employee_id');
    } 
    public function contractual_type()
    {
        return $this->belongsTo('App\Models\ContractualType', 'contractual_type_id');
    }    
}
