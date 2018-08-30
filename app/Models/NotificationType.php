<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationType extends Model
{
    protected $table = 'notification_types';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
        'description',
        'delete_flag'
    ];

    public function notifications()
    {
        return $this->hasMany('App\Models\Notifications');
    }
}
