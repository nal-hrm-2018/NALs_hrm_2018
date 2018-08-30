/**
* Created by Dung Le.
* User: PC
* Date: 8/29/2018
* Time: 10:05 AM
*/
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
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{trans('notification.new')}}</h3>
                    </div>
                    <div class="box-body">
                        <div class="news">
                            <ul data-widget="tree" style="list-style-type: none;">
                                @foreach($new_notifications as $note)
                                    <li class="treeview">
                                        @if($note->notification_type=='HR')
                                            <label class="label bg-yellow" style="width: 40px; display: inline-block;">HR</label>
                                        @endif
                                        @if($note->notification_type=='HD')
                                            <span class="label bg-red" style="width: 40px; display: inline-block;">HD</span>
                                        @endif
                                        @if($note->notification_type=='DOREMON')
                                            <span class="label bg-green" style="width: 40px; display: inline-block;">DRM</span>
                                        @endif
                                        <span class="pull-right">
                                            <a href="#">{{trans('notification.edit')}}</a>
                                            <a href="#">{{trans('notification.delete')}}</a>
                                         </span>
                                        <a href="#">
                                            <span style="vertical-align: middle;">{{$note->content}}</span>
                                        </a>
                                        <ul class="treeview-menu">
                                            <?php
                                            echo nl2br($note->detail);
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
                  <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{trans('common.history_notifications')}}</h3>
                    </div>
                    <div class="box-body">
                        <div class="news">
                            <ul data-widget="tree" style="list-style-type: none;">
                                @foreach($old_notifications as $note)
                                    <li class="treeview">
                                        @foreach($notification_type as $type)
                                            @if($note->type_id == $type->id)
                                                <label class="label bg-yellow" style="width: 40px; display: inline-block;">{{$type->name}}</label>
                                            @endif
                                            @if($note->notification_type == $type->id)
                                                <span class="label bg-red" style="width: 40px; display: inline-block;">{{$type->name}}</span>
                                            @endif
                                            @if($note->notification_type == $type->id)
                                                <span class="label bg-green" style="width: 40px; display: inline-block;">{{$type->name}}</span>
                                            @endif
                                         @endforeach
                                        <span class="pull-right">
                                            <a href="#">{{trans('notification.edit')}}</a>
                                            <a href="#">{{trans('notification.delete')}}</a>
                                         </span>
                                        <a href="#">
                                            <span style="vertical-align: middle;">{{$note->content}}</span>
                                        </a>
                                        <ul class="treeview-menu">
                                            <?php
                                            echo nl2br($note->detail);
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