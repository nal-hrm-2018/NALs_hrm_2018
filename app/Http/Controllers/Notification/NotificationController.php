<?php

namespace App\Http\Controllers\Notification;

use Illuminate\Http\Request;
use App\Http\Requests\NotificationAddRequest;
use App\Http\Controllers\Controller;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use App\Models\Notifications;
use App\Models\NotificationType;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notification_type = NotificationType::Where('delete_flag','0')->get();
        $new_notifications = Notifications::where('end_date','>=',date('Y-m-d').' 00:00:00')
                                            ->Where('delete_flag','0')
                                            ->orderBy('id','desc')->get();
        $old_notifications = Notifications::Where('delete_flag','1')
                                            ->orwhere('end_date','<',date('Y-m-d').' 00:00:00')
                                            ->orderBy('id','desc')->get();
        return view('notification.list',[
            'notification_type' => $notification_type,
            'new_notifications' => $new_notifications,
            'old_notifications' => $old_notifications,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dataTeam = NotificationType::select('id', 'name')->where('delete_flag', 0)->get();
        return view('notification.add',compact('dataTeam'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NotificationAddRequest $request)
    {
        $count = Notifications::where('delete_flag','=','0')->count();

        if ($count>=10)
        {
            \Session::flash('msg_fail', trans('notification.msg_add.fail_than_ten'));
            return redirect('notification');
        }

        $create_by_employee = Auth::user()->id;
        $notification = new Notifications();
        $notification->create_by_employee = $create_by_employee;
        $notification->title = $request->title;
        $notification->content = $request->content;
        $notification->end_date = $request->date;
        $notification->notification_type_id = NotificationType::where('name','NALs')->value('id');
        if ($notification->save())
        {
            \Session::flash('msg_success', trans('notification.msg_add.success'));
            return redirect('notification');
        } else {
            \Session::flash('msg_fail', trans('notification.msg_add.fail'));
            return back()->with(['notification' => $notification]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        echo $id; die();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $notification = Notifications::where('delete_flag',0)->find($id);
        $notificationType = NotificationType::select('id','name')->get();
        return view('notification.edit',compact('notification','notificationType'));
    }

    /**
     * Update the specified resource in storNotificationAddRequestage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(NotificationAddRequest $request, $id)
    {
        $notification = Notifications::where('delete_flag', 0)->find($id);
        $notification->title = $request->title;
        $notification->content = $request->content;
        $notification->end_date = $request->date;
        $notification->notification_type_id = NotificationType::where('name','NALs')->value('id');
        if($notification->save()){
            \Session::flash('msg_success', trans('notification.msg_edit.success'));
            return redirect('notification');
        }else{
            \Session::flash('msg_fail', trans('notification.msg_edit.fail'));
            return back()->with(['notification' => $notification]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $notification = Notifications::where('id', $id)->where('delete_flag', 0)->first();
        $notification->delete_flag = 1;
        $notification->save(); 
        \Session::flash('msg_success', trans('notification.msg_delete.success'));
        return redirect('notification');
    }
}
