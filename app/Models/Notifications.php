<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    public $table = 'notification';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'content',
        'detail',
        'created_by_employee',
        'created_at',
        'updated_at',
        'updated_by_employee',
        'delete_flag'
    ];

    public function notificationTypes()
    {
        return $this->belongsto('App\Models\NotificationType', 'notification_id');
    }
}
