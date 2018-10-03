<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li>
          <a href="{{route('dashboard-user')}}">
            <i class="glyphicon glyphicon-dashboard"></i> <span>{{trans('leftbar.nav.dashboard')}}</span>
          </a>
        </li>
        @if(Auth::user()->hasRole('BO'))
         <li class="treeview">
          <a href="#">
            <i class="glyphicon glyphicon-blackboard"></i> <span>{{trans('leftbar.nav.notification')}}</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
              <li><a href="{{ asset('notification')}}"><i class="fa fa-circle-o-notch"></i>{{trans('leftbar.nav.list.notification')}}</a></li>
              <li><a href="{{ asset('notification/create')}}"><i class="fa fa-circle-o-notch"></i>{{trans('leftbar.nav.add.notification')}}</a></li>
          </ul>
        </li>
        @endif
        @if(Auth::user()->hasPermission('view_list_employee')||Auth::user()->hasPermission('add_new_employee'))
        <li class="treeview">
          <a href="#">
            <i class="glyphicon glyphicon-user"></i> <span>{{trans('leftbar.nav.employee')}}</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
              @if(Auth::user()->hasPermission('view_list_employee'))
            <li><a href="{{ asset('employee')}}"><i class="fa fa-circle-o-notch"></i>{{trans('leftbar.nav.list.employee')}}</a></li>
              @endif

              @if(Auth::user()->hasPermission('add_new_employee'))
            <li><a href="{{ asset('employee/create')}}"><i class="fa fa-circle-o-notch"></i>{{trans('leftbar.nav.add.employee')}}</a></li>
              @endif
          </ul>
        </li>
          @endif
        <!-- 1/8/hiddent_cmt-->
        <li class="treeview">
          {{--<a href="#">--}}
            {{--<i class="fa fa-handshake-o"></i> <span>{{trans('leftbar.nav.vendor')}}</span>--}}
            {{--<span class="pull-right-container">--}}
              {{--<i class="fa fa-angle-left pull-right"></i>--}}
            {{--</span>--}}
          {{--</a>--}}
          {{--<ul class="treeview-menu">--}}
            {{--<li><a href="{{ asset('vendors')}}"><i class="fa fa-circle-o-notch"></i>{{trans('leftbar.nav.list.vendor')}}</a></li>--}}
            {{--<li><a href="{{ asset('vendors/create')}}"><i class="fa fa-circle-o-notch"></i>{{trans('leftbar.nav.add.vendor')}}</a></li>--}}
          {{--</ul>--}}
        {{--</li>--}}
        {{--<li class="treeview">--}}
          {{--<a href="#">--}}
            {{--<i class="fa fa-heartbeat"></i> <span>{{trans('leftbar.nav.team')}}</span>--}}
              {{--<span class="pull-right-container">--}}
              {{--<i class="fa fa-angle-left pull-right"></i>--}}
            {{--</span>--}}
          {{--</a>--}}
          {{--<ul class="treeview-menu">--}}
            {{--<li><a href="{{ asset('teams')}}"><i class="fa fa-circle-o-notch"></i>{{trans('leftbar.nav.list.team')}}</a></li>--}}
            {{--<li><a href="{{ asset('teams/create')}}"><i class="fa fa-circle-o-notch"></i>{{trans('leftbar.nav.add.team')}}</a></li>--}}
          {{--</ul>--}}
        </li>
        
        <li class="treeview">
          <a href="#">
            <i class="glyphicon glyphicon-globe"></i> <span>{{trans('leftbar.nav.project')}}</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ asset('projects')}}"><i class="fa fa-circle-o-notch"></i>{{trans('leftbar.nav.list.project')}}</a></li>
            @if(Auth::user()->hasRole('PO'))
              <li><a href="{{ asset('projects/create')}}"><i class="fa fa-circle-o-notch"></i>{{trans('leftbar.nav.add.project')}}</a></li>
            @endif
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="glyphicon glyphicon-calendar"></i> <span>{{trans('leftbar.nav.absence')}}</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            @if(Auth::user()->hasPermission('view_absence_history'))
              <li><a class="nav-item-part" href="{{ asset('absences')}}"><i class="fa fa-circle-o-notch"></i>{{trans('leftbar.nav.list.history')}}</a></li>
            @endif
            @if(Auth::user()->hasPermission('add_new_absence'))
              <li><a class="nav-item-part" href="{{ asset('absences/create')}}"><i class="fa fa-circle-o-notch"></i>{{trans('leftbar.nav.add.absence')}}</a></li>
            @endif
            @if(Auth::user()->hasPermission('view_employee_absence_history'))
                <li><a class="nav-item-part" href="{{ asset('absences/hr')}}"><i class="fa fa-circle-o-notch"></i>{{trans('leftbar.nav.absence_management')}}</a></li>
              @endif
              @if(Auth::user()->hasPermission('view_holiday_list'))
                <li><a class="nav-item-part" href="{{ asset('holiday')}}"><i class="fa fa-circle-o-notch"></i>{{trans('leftbar.nav.list.absences_holiday')}}</a></li>
              @endif
              @if(Auth::user()->hasPermission('view_project_absence_history'))
                <li><a class="nav-item-part" href="{{ asset('absence/po-project')}}"><i class="fa fa-circle-o-notch"></i>{{trans('leftbar.nav.absence_management')}}</a></li>
              @endif
          </ul>
        </li>
        <li class="treeview">
            <a href="#">
                <i class="glyphicon glyphicon-time"></i> <span>{{trans('leftbar.nav.overtime')}}</span>
                <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
            </a>
            <ul class="treeview-menu">
                <li><a class="nav-item-part" href="{{ asset('ot')}}"><i class="fa fa-circle-o-notch"></i>{{trans('leftbar.nav.list.overtime')}}</a></li>
                <li><a class="nav-item-part" href="{{ asset('ot/create')}}"><i class="fa fa-circle-o-notch"></i>{{trans('leftbar.nav.add.overtime')}}</a></li>
                @if(Auth::user()->hasRole('PO'))
                    <li><a class="nav-item-part" href="{{ asset('ot/po-ot')}}"><i class="fa fa-circle-o-notch"></i>{{trans('leftbar.nav.overtime_management')}}</a></li>
                @endif
                @if(Auth::user()->hasRole('BO'))
                    <li><a class="nav-item-part" href="{{ asset('ot/hr-ot')}}"><i class="fa fa-circle-o-notch"></i>{{trans('leftbar.nav.overtime_management')}}</a></li>
                @endif
            </ul>
        </li>
        <li class="treeview">
          <a href="#">
              <i class="glyphicon glyphicon-print"></i> <span>{{trans('leftbar.nav.quit_process')}}</span>
              <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
          </a>
          <ul class="treeview-menu">
              <li><a class="nav-item-part" href="{{ asset('quit_process')}}"><i class="fa fa-circle-o-notch"></i>{{trans('leftbar.nav.list.quit_process')}}</a></li>
              <li><a class="nav-item-part" href="{{ asset('quit_process/create')}}"><i class="fa fa-circle-o-notch"></i>{{trans('leftbar.nav.add.quit')}}</a></li>
              
            </ul>
        </li>
        @if((Auth::user()->hasPermission('view_employee_absence_history')) || (Auth::user()->hasPermission('view_holiday_list')) || (Auth::user()->hasPermission('view_project_absence_history')) )
          <!-- <li class="treeview">
            <a href="#">
              <i class="fa  fa-calendar-minus-o"></i> <span>{{trans('leftbar.nav.absence_management')}}</span>
              <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
              @if(Auth::user()->hasPermission('view_employee_absence_history'))
                <li><a class="nav-item-part" href="{{ asset('absences/hr')}}"><i class="fa fa-circle-o-notch"></i>{{trans('leftbar.nav.list.absences_hr')}}</a></li>
              @endif
              @if(Auth::user()->hasPermission('view_holiday_list'))
                <li><a class="nav-item-part" href="{{ asset('holiday')}}"><i class="fa fa-circle-o-notch"></i>{{trans('leftbar.nav.list.absences_holiday')}}</a></li>
              @endif
              @if(Auth::user()->hasPermission('view_project_absence_history'))
                <li><a class="nav-item-part" href="{{ asset('absence/po-project')}}"><i class="fa fa-circle-o-notch"></i>{{trans('leftbar.nav.list.absences_po_project')}}</a></li>
              @endif
            </ul>
          </li> -->
        @endif
      </ul>

    </section>
    <!-- /.sidebar -->
  </aside>

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
            // else if(href.split('/').length > 1){
            //     if(path == href.split('/')[3]){
            //         $(this).parent().parent().addClass('active');
            //         $(this).parent().css('display', 'none');
            //     }
            // }
        });
    });
</script>
  