@extends('admin.template')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                {{trans('common.title_header.notification_list')}}
                <small>NAL Solutions</small>
            </h1>
        </section>
        <div id="msg">
        </div>
        <section class="content-header">
            <div>
                <button type="button" class="btn btn-default">
                    <a href="{{route('notification.create')}}"><i class="fa fa-user-plus"></i>{{trans('notification.add')}}</a>
                </button>
            </div>
            <br>
        </section>
        <div class="content">
            <section>
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{trans('notification.new')}}</h3>
                    </div>
                    <div class="box-body">
                        <div class="news">
                            <ul data-widget="tree" style="list-style-type: none;">
                                @foreach($new_notifications as $note)
                                    <li class="treeview" style="display: table; width: 100%; margin-bottom: 10px;">
                                        @foreach($notification_type as $type)
                                            @if($note->notification_type_id == $type->id)
                                                @if($type->name == 'HD')
                                                    <label class="label bg-red" style="width: 40px; display: inline-block;">HD</label>
                                                @endif
                                                @if($type->name == 'HR')
                                                    <label class="label bg-yellow" style="width: 40px; display: inline-block;">HR</label>
                                                @endif
                                                @if($type->name == 'DOREMON')
                                                    <label class="label bg-green" style="width: 40px; display: inline-block;">DRM</label>
                                                @endif
                                            @endif
                                        @endforeach
                                        <span class="pull-right">
                                            <a href="notification/{{$note->id}}/edit" class="btn btn-default">
                                                <i class="fa fa-pencil width-icon-contextmenu"></i>
                                                {{--{{trans('notification.edit')}}--}}
                                            </a>
                                            <a onclick="return confirm_delete();" class="btn btn-danger" href="{{ route('notification.destroy',['notification' => $note->id]) }}">
                                                 <i class="fa fa-remove width-icon-contextmenu"></i>
                                                {{--{{trans('notification.delete')}}--}}
                                            </a>
                                         </span>
                                        <a href="#">
                                            <span style="vertical-align: middle;">{{$note->title}}</span>
                                        </a>
                                        <ul class="treeview-menu">
                                            <?php
                                            echo nl2br($note->content);
                                            ?>
                                            <hr>
                                        </ul>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
            <section>
                @if(count($old_notifications))
                  <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{trans('common.history_notifications')}}</h3>
                    </div>
                    <div class="box-body">
                        <div class="news">
                            <ul data-widget="tree" style="list-style-type: none;">
                                @foreach($old_notifications as $note)
                                    <li class="treeview">
                                        @foreach($notification_type as $type)
                                            @if($note->notification_type_id == $type->id)
                                                @if($type->name == 'HD')
                                                    <label class="label bg-red" style="width: 40px; display: inline-block;">HD</label>
                                                @endif
                                                @if($type->name == 'HR')
                                                    <label class="label bg-yellow" style="width: 40px; display: inline-block;">HR</label>
                                                @endif
                                                @if($type->name == 'DOREMON')
                                                    <label class="label bg-green" style="width: 40px; display: inline-block;">DRM</label>
                                                @endif
                                            @endif
                                        @endforeach

                                        <a href="#">
                                            <span style="vertical-align: middle;">{{$note->title}}</span>
                                        </a>
                                        <ul class="treeview-menu">
                                            <?php
                                            echo nl2br($note->content);
                                            ?>
                                            <hr>
                                        </ul>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                @endif
            </section>
        </div>
    </div>
    <script>
        function confirm_delete(){
            return confirm(message_confirm('{{trans('common.action.remove')}}','{{trans('notification.notification')}}',''));
        }
    </script>
@endsection