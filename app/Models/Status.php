<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'statuses';
    protected $fillable = [
        'id','name'
    ];
    public function projects()
    {
        return $this->hasMany(Project::class,'status_id');
    }
}
