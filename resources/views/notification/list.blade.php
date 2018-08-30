@extends('admin.template')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="content">
            <section class="content-header">
                <h1>
                    {{trans('common.notifications')}}
                    <small>NAL Solutions</small>
                </h1>
                {{--<ol class="breadcrumb">--}}
                {{--<li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>--}}
                {{--<li><a href=""> Absance</a></li>--}}
                {{--<li><a href="{{asset('/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>--}}
                {{--<li><a href="{{asset('/absences')}}"> Absance</a></li>--}}
                {{--<li><a href="#">List</a></li>--}}
                {{--</ol>--}}
            </section>
            <section class="content-header">
                <div>
                    <button type="button" class="btn btn-default">
                        <a href="{{route('notification.create')}}"><i class="fa fa-user-plus"></i>{{trans('notification.add')}}</a>
                    </button>
                </div>
                <br>
            </section>
            <section>
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{trans('notification.new')}}</h3>
                    </div>
                    <div class="box-body">
                        <div class="news">
                            <ul data-widget="tree" style="list-style-type: none;">
                                @foreach($new_notifications as $note)
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
                                        <span class="pull-right">
                                            <a href="#">
                                                <i class="fa fa-edit width-icon-contextmenu"></i>
                                                {{--{{trans('notification.edit')}}--}}
                                            </a>
                                            <a href="#">
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
                                            <span class="pull-right">
                                            <a href="#">
                                                <i class="fa fa-edit width-icon-contextmenu"></i>
                                                {{--{{trans('notification.edit')}}--}}
                                            </a>
                                            <a href="#">
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
                @endif
            </section>
        </div>
    </div>
@endsection