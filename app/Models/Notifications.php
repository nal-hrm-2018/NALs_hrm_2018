<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    public $table = 'notification';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'title',
        'content',
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
    public function deleteNotificationExpired()
    {
        //danh sách thông báo hết hạn chưa xóa 2018-09-21 00:00:00
        $allNotificationExpired = Notifications::where('end_date','<',date('Y-m-d').' 00:00:00')
                                                ->where('delete_flag',0)->get();

        foreach($allNotificationExpired as $notification){
            $notification = Notifications::where('id',$notification->id)->first();
            $notification->delete_flag = 1;
            $notification->save();
        }
        return $allNotificationExpired;
    }
}
