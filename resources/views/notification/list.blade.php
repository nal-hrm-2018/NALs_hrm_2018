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
            <section>
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{trans('common.notifications')}}</h3>
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
                                        @if($note->notification_type=='HR')
                                            <label class="label bg-yellow" style="width: 40px; display: inline-block;">HR</label>
                                        @endif
                                        @if($note->notification_type=='HD')
                                            <span class="label bg-red" style="width: 40px; display: inline-block;">HD</span>
                                        @endif
                                        @if($note->notification_type=='DOREMON')
                                            <span class="label bg-green" style="width: 40px; display: inline-block;">DRM</span>
                                        @endif
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