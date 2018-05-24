<?php
/**
 * Created by PhpStorm.
 * User: Ngoc Quy
 * Date: 4/16/2018
 * Time: 11:00 AM
 */ ?>
@extends('admin.template')
@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Project List
                <small>Nal solution</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{asset('/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="{{asset('/projects')}}"> Project</a></li>
                <li><a href="#">List</a></li>
            </ol>
        </section>

       {{-- <section class="content-header">
            <div>
                <button type="button" class="btn btn-info btn-default" data-toggle="modal" data-target="#myModal">
                    SEARCH
                </button>

                <!-- Modal -->
                <div id="myModal" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <form method="get" role="form" id="form_search_employee">
                            <!-- Modal content-->
                            <input id="number_record_per_page" type="hidden" name="number_record_per_page"
                                   value="{{ isset($param['number_record_per_page'])?$param['number_record_per_page']:config('settings.paginate') }}"/>
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">{{  trans('common.title_form.form_search') }}</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <div class="input-group margin">
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn width-100">Employee ID</button>
                                                </div>
                                                <input type="text" name="id" id="employeeId" class="form-control">
                                            </div>
                                            <div class="input-group margin">
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn width-100">Name</button>
                                                </div>
                                                --}}{{--<input type="text" name="name" id="nameEmployee" class="form-control">--}}{{--
                                                {{ Form::text('name', old('name'),
                                                    ['class' => 'form-control',
                                                    'id' => 'nameEmployee',
                                                    'autofocus' => true,
                                                    ])
                                                }}
                                            </div>
                                            <div class="input-group margin">
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn width-100">Team</button>
                                                </div>
                                                <select name="team" id="team_employee" class="form-control">
                                                    --}}{{--@if(!empty($_GET['team']))
                                                        <option selected="selected" {{'hidden'}}  value="">
                                                            {{$_GET['team']}}
                                                        </option>
                                                    @else
                                                        <option selected="selected" value="">
                                                        {{  trans('employee.drop_box.placeholder-default') }}
                                                    @endif--}}{{--
                                                    <option {{ !empty(request('team'))?'':'selected="selected"' }} value="">
                                                        {{  trans('vendor.drop_box.placeholder-default') }}
                                                    </option>
                                                    @foreach($teams as $team)
                                                        <option value="{{ $team->name}}" {{ (string)$team->name===request('team')?'selected="selected"':'' }}>
                                                            {{ $team->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <div class="input-group margin">
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn width-100">Email</button>
                                                </div>
                                                --}}{{--<input type="text" name="email" id="emailEmployee" class="form-control">--}}{{--
                                                {{ Form::text('email', old('email'),
                                                    ['class' => 'form-control',
                                                    'id' => 'emailEmployee',
                                                    'autofocus' => true,
                                                    ])
                                                }}
                                            </div>
                                            <div class="input-group margin">
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn width-100">Role</button>
                                                </div>
                                                <select name="role" id="role_employee" class="form-control">
                                                    --}}{{--@if(!empty($_GET['role']))
                                                        <option selected="selected" {{'hidden'}}  value="">
                                                            {{$_GET['role']}}
                                                        </option>
                                                    @else
                                                        <option selected="selected"
                                                                value="">
                                                            {{  trans('employee.drop_box.placeholder-default') }}
                                                            @endif
                                                        </option>--}}{{--
                                                    <option {{ !empty(request('role'))?'':'selected="selected"' }} value="">
                                                        {{  trans('vendor.drop_box.placeholder-default') }}
                                                    </option>
                                                    @foreach($roles as $role)
                                                        <option value="{{ $role->name}}"{{ (string)$role->name===request('role')?'selected="selected"':'' }}>
                                                            {{ $role ->name}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="input-group margin">
                                                <div class="input-group-btn">
                                                    <button type="button"
                                                            class="btn width-100">{{trans('employee.profile_info.status')}}</button>
                                                </div>
                                                <select name="status" id="status" class="form-control">
                                                    <option {{ !empty(request('status'))?'':'selected="selected"' }} value="">
                                                        {{  trans('employee.drop_box.placeholder-default') }}
                                                    </option>
                                                    @foreach($status as $key=>$value)
                                                        <option value="{{ $key }}" {{ (string)$key===request('status')?'selected="selected"':'' }}>
                                                            {{ $value }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer center">
                                    <button id="btn_reset_employee" type="button" class="btn btn-default"><span
                                                class="fa fa-refresh"></span>
                                        RESET
                                    </button>
                                    <button type="submit" id="searchListEmployee" class="btn btn-primary"><span
                                                class="fa fa-search"></span>
                                        SEARCH
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>--}}
    </div>

@endsection