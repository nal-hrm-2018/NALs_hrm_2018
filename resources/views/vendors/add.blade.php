@extends('admin.template')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{trans('vendor.title_header.add_vendor')}}
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{route('dashboard-user')}}"><i class="fa fa-dashboard"></i> {{trans('common.path.home')}}
                    </a></li>
                <li><a href="{{route('vendors.index')}}">{{trans('common.path.vendors')}}</a></li>
                <li class="active"><a href="javascript:void(0)">{{trans('vendor.title_header.add_vendor')}}</a></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- SELECT2 EXAMPLE -->
            <div class="box box-default">
                <div class="box-body">
                    <div id="msg"></div>
                    @include('vendors._form_add_vendor')
                    <script type="text/javascript"
                            src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
                    <script>
                        function confirmAction($msg) {
                            return confirm($msg);
                        }
                        $(function () {
                            $("#btn_reset_form_vendor").on("click", function () {
                                $("#email").val('');
                                $("#password").val('');
                                $("#cfPass").val('');
                                $("#name").val('');
                                $("#address").val('');
                                $("#mobile").val('');
                                $("#gender").val('').change();
                                $("#married").val('').change();
                                $("#role_team").val('').change();
                                $("#position").val('').change();
                                $("#birthday").val('value', '');
                                $("#startwork_date").val('value', '');
                                $("#endwork_date").val('value', '');
                            });
                        });

                        $(function () {
                            $('#form_create_vendor').submit(function () {
                                return confirmAction('{{trans('common.confirm_message.add_action')}}');
                            });
                        });
                    </script>
                    <!-- /.row -->
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </section>
        <!-- /.content -->
    </div>
@endsection