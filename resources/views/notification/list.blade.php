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
                    <a href="{{route('notification.create')}}"><i class="glyphicon glyphicon-plus"></i>&nbsp;{{trans('notification.add')}}</a>
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
                    <style>
                        .read-more-state {
                        display: none;
                        }

                        .read-more-target {
                        opacity: 0;
                        max-height: 0;
                        font-size: 0;
                        transition: .25s ease;
                        }

                        .read-more-state:checked ~ .read-more-wrap .read-more-target {
                        opacity: 1;
                        font-size: inherit;
                        max-height: 999em;
                        }

                        .read-more-state ~ .read-more-trigger:before {
                        content: '>>>';
                        }

                        .read-more-state:checked ~ .read-more-trigger:before {
                        content: '<<<';
                        }

                        .read-more-trigger {
                        cursor: pointer;
                        display: inline-block;
                        padding: 0 .5em;
                        color: #666;
                        font-size: .9em;
                        line-height: 2;
                        border: 1px solid #ddd;
                        border-radius: .25em;
                        }
                    </style>
                    <div class="box-body">
                        <div class="news">
                            <ul data-widget="tree" style="list-style-type: none; padding: 0px 40px;">
                                @if($new_notifications->count()<=0)
                                {{trans('notification.no_notification')}}
                                @endif
                                @foreach($new_notifications as $note)
                                    <li class="treeview" style="display: table; width: 100%; margin-bottom: 10px;">
                                        <div class="col-xs-12 col-md-11">
                                            <label class="label bg-yellow" style="width: 40px; display: inline-block;">NALs</label>
                                            <a href="#">
                                                <span style="color: black; ">[{{date('d/m',strtotime($note->create_at))}}]</span>
                                                <span style="vertical-align: middle; color: black;">{{$note->title}}</span>
                                            </a>
                                            <div class="span4 collapse-group">
                                                <input type="text" id="id_note" value="{{$note->id}}" hidden />
                                                <div>
                                                    <input type="checkbox" class="read-more-state" id="post-{{$note->id}}" />
                                
                                                <p class="read-more-wrap">{{substr($note->content,0,50)}}<span class="read-more-target">{{substr($note->content,50)}}</span></p>
                                                    <label for="post-{{$note->id}}" class="read-more-trigger"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-md-1">
                                            <span class="">
                                                <a href="notification/{{$note->id}}/edit" class="btn btn-default">
                                                    <i class="fa fa-pencil width-icon-contextmenu"></i>
                                                </a>
                                                <a onclick="return confirm_delete();" class="btn btn-danger" href="{{ route('notification.destroy',['notification' => $note->id]) }}">
                                                        <i class="fa fa-remove width-icon-contextmenu"></i>
                                                </a>
                                            </span>
                                        </div>
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
                            <ul data-widget="tree" style="list-style-type: none; padding: 0px 40px;">
                                @foreach($old_notifications as $note)
                                    <li class="treeview" style="display: table; width: 100%; margin-bottom: 10px;">
                                        <div class="col-xs-12 col-md-11">
                                            <label class="label bg-yellow" style="width: 40px; display: inline-block;">NALs</label>
                                            <a href="#">
                                                <span style="color: black; ">[{{date('d/m',strtotime($note->create_at))}}]</span>
                                                <span style="vertical-align: middle; color: black;">{{$note->title}}</span>
                                            </a>
                                            <div class="span4 collapse-group">
                                                <input type="text" id="id_note" value="{{$note->id}}" hidden />
                                                <div>
                                                    <input type="checkbox" class="read-more-state" id="post-{{$note->id}}" />
                                
                                                <p class="read-more-wrap">{{substr($note->content,0,50)}}<span class="read-more-target">{{substr($note->content,50)}}</span></p>
                                                    <label for="post-{{$note->id}}" class="read-more-trigger"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-md-1">
                                            <span class="">
                                                <a href="notification/{{$note->id}}/edit" class="btn btn-default">
                                                    <i class="fa fa-pencil width-icon-contextmenu"></i>
                                                </a>
                                                <a onclick="return confirm_delete();" class="btn btn-danger" href="{{ route('notification.destroy',['notification' => $note->id]) }}">
                                                        <i class="fa fa-remove width-icon-contextmenu"></i>
                                                </a>
                                            </span>
                                        </div>
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
    <style type="text/css">
        .box-notification-red {
            margin-top: 1.5em;
            margin-bottom: 0.5em;
            margin-left: auto;
            margin-right: auto;
            padding: 20px;
            border: 1px solid;
            border-radius: 5px;
            border-color: red;
            color: #777;
        }

        .box-notification-yellow {
            margin-top: 1.5em;
            margin-bottom: 0.5em;
            margin-left: auto;
            margin-right: auto;
            padding: 20px;
            border: 1px solid;
            border-radius: 5px;
            border-color: #f39c12;
            color: #777;
        }

        .box-notification-green {
            margin-top: 1.5em;
            margin-bottom: 0.5em;
            margin-left: auto;
            margin-right: auto;
            padding: 20px;
            border: 1px solid;
            border-radius: 5px;
            border-color: green;
            color: #777;
        }
    </style>
@endsection