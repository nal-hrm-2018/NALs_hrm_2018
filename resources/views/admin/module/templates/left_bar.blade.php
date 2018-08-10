<nav class="is-flex is-column nav-menu">
    <!-- sidebar: style can be found in sidebar.less --><!-- sidebar menu: : style can be found in sidebar.less -->
        <ul data-widget="tree">
            <li>
                <a href="{{route('dashboard-user')}}" class="active nav-item">
                    <img src="{!! asset('admin/templates/images/dist/img/menu-dashboard.png') !!}" class="mg-right-10">
                    <span>{{trans('leftbar.nav.dashboard')}}</span>
                </a>
            </li>
            @if(Auth::user()->hasPermission('view_list_employee')||Auth::user()->hasPermission('add_new_employee'))
            <li class="treeview">
                <a href="#" class="nav-item">
                    <img src="{!! asset('admin/templates/images/dist/img/menu-employess.png') !!}" class="mg-right-10">
                    <span>{{trans('leftbar.nav.employee')}}</span>
                    {{--<span class="pull-right-container">--}}
                      {{--<i class="fa fa-angle-left pull-right"></i>--}}
                    {{--</span>--}}
                </a>
                <ul class="treeview-menu">
                    @if(Auth::user()->hasPermission('view_list_employee'))
                        <li><a class="nav-item-part" href="{{ asset('employee')}}"><i class="fa fa-circle-o-notch"></i>{{trans('leftbar.nav.list.employee')}}</a></li>
                    @endif

                    @if(Auth::user()->hasPermission('add_new_employee'))
                        <li><a class="nav-item-part" href="{{ asset('employee/create')}}"><i class="fa fa-circle-o-notch"></i>{{trans('leftbar.nav.add.employee')}}</a></li>
                    @endif
                </ul>
            </li>
            @endif
        <!-- 1/8/hiddent_cmt-->
            {{--<li class="treeview">--}}
                {{--<a href="#" class="nav-item">--}}
                    {{--<img src="{!! asset('admin/templates/images/dist/img/menu-vendor.png') !!}" class="mg-right-10">--}}
                    {{--<span>{{trans('leftbar.nav.vendor')}}</span>--}}
                    {{--<span class="pull-right-container">--}}
                    {{--<i class="fa fa-angle-left pull-right"></i>--}}
                    {{--</span>--}}
                {{--</a>--}}
                {{--<ul class="treeview-menu">--}}
                    {{--<li><a class="nav-item-part" href="{{ asset('vendors')}}"><i class="fa fa-circle-o-notch"></i>{{trans('leftbar.nav.list.vendor')}}</a></li>--}}
                    {{--<li><a class="nav-item-part" href="{{ asset('vendors/create')}}"><i class="fa fa-circle-o-notch"></i>{{trans('leftbar.nav.add.vendor')}}</a></li>--}}
                {{--</ul>--}}
            {{--</li>--}}
            {{--<li class="treeview">--}}
                {{--<a href="#" class="nav-item">--}}
                    {{--<img src="{!! asset('admin/templates/images/dist/img/menu-team.png') !!}" class="mg-right-10">--}}
                    {{--<span>{{trans('leftbar.nav.team')}}</span>--}}
                    {{--<span class="pull-right-container">--}}
                    {{--<i class="fa fa-angle-left pull-right"></i>--}}
                    {{--</span>--}}
                {{--</a>--}}
                {{--<ul class="treeview-menu">--}}
                {{--<li><a class="nav-item-part" href="{{ asset('teams')}}"><i class="fa fa-circle-o-notch"></i>{{trans('leftbar.nav.list.team')}}</a></li>--}}
                {{--<li><a class="nav-item-part" href="{{ asset('teams/create')}}"><i class="fa fa-circle-o-notch"></i>{{trans('leftbar.nav.add.team')}}</a></li>--}}
                {{--</ul>--}}
            {{--</li>--}}
            {{--<li class="treeview">--}}
                {{--<a href="#" class="nav-item">--}}
                    {{--<img src="{!! asset('admin/templates/images/dist/img/menu-project.png') !!}" class="mg-right-10">--}}
                    {{--<span>{{trans('leftbar.nav.project')}}</span>--}}
                    {{--<span class="pull-right-container">--}}
                        {{--<i class="fa fa-angle-left pull-right"></i>--}}
                    {{--</span>--}}
                {{--</a>--}}
                {{--<ul class="treeview-menu">--}}
                {{--<li><a class="nav-item-part" href="{{ asset('projects')}}"><i class="fa fa-circle-o-notch"></i>{{trans('leftbar.nav.list.project')}}</a></li>--}}
                {{--<li><a class="nav-item-part" href="{{ asset('projects/create')}}"><i class="fa fa-circle-o-notch"></i>{{trans('leftbar.nav.add.project')}}</a></li>--}}
                {{--</ul>--}}
            {{--</li>--}}
            {{----}}
            <li class="treeview">
                <a href="#" class="nav-item">
                    <img src="{!! asset('admin/templates/images/dist/img/menu-absence.png') !!}" class="mg-right-10">
                    <span>{{trans('leftbar.nav.absence')}}</span>
                    {{--<span class="pull-right-container">--}}
                        {{--<i class="fa fa-angle-left pull-right"></i>--}}
                    {{--</span>--}}
                </a>
                <ul class="treeview-menu">

                    @if(Auth::user()->hasPermission('view_absence_history'))
                        <li><a class="nav-item-part" href="{{ asset('absences')}}"><i class="fa fa-circle-o-notch"></i>{{trans('leftbar.nav.list.absence')}}</a></li>
                    @endif
                    @if(Auth::user()->hasPermission('add_new_absence'))
                        <li><a class="nav-item-part" href="{{ asset('absences/create')}}"><i class="fa fa-circle-o-notch"></i>{{trans('leftbar.nav.add.absence')}}</a></li>
                    @endif
                    @if(Auth::user()->hasPermission('view_employee_absence_history'))
                        <li><a class="nav-item-part" href="{{ asset('absences/hr')}}"><i class="fa fa-circle-o-notch"></i>{{trans('leftbar.nav.list.absences_hr')}}</a></li>
                    @endif
                    @if(Auth::user()->hasPermission('view_holiday_list'))
                        <li><a class="nav-item-part" href="{{ asset('absences/holiday')}}"><i class="fa fa-circle-o-notch"></i>{{trans('leftbar.nav.list.absences_holiday')}}</a></li>
                    @endif
                    @if(Auth::user()->hasPermission('view_project_absence_history'))
                        <li><a class="nav-item-part" href="{{ asset('absence/po-project')}}"><i class="fa fa-circle-o-notch"></i>{{trans('leftbar.nav.list.absences_po_project')}}</a></li>
                    @endif
                </ul>
            </li>

        </ul>

    <!-- /.sidebar -->
</nav>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
    var url = window.location.href;
    // var path = window.location.pathname;
    $(document).ready(function () {
        // alert(url);
        var path = url.split('/')[3];
        $('.sidebar-menu li').each(function () {
            var href = $(this).find('a').attr('href');

            if(url == href || url.split('?')[0] == href){
                $(this).addClass('active');
                $(this).find('i').attr('class', 'fa fa-bullseye');
                $(this).parent().css('display', 'block');
                $(this).parent().parent().addClass('menu-open active');
                return false;
            }
            else if(href.split('/').length > 1){
                if(path == href.split('/')[3]){
                    $(this).parent().parent().addClass('active');
                    $(this).parent().css('display', 'none');
                }
            }
        });
    });
</script>
