<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li>
          <a href="">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-users"></i> <span>Employee</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ asset('employee')}}"><i class="fa fa-circle-o"></i> List Employee</a></li>
            <li><a href="{{ asset('employee/create')}}"><i class="fa fa-circle-o"></i> Add Employee</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-handshake-o"></i> <span>Vendor</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ asset('vendors')}}"><i class="fa fa-circle-o"></i> List Vendor</a></li>
            <li><a href="{{ asset('vendors/create')}}"><i class="fa fa-circle-o"></i> Add Vendor</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-heartbeat"></i> <span>Team</span>
              <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ asset('teams')}}"><i class="fa fa-circle-o"></i> List Team</a></li>
            <li><a href="{{ asset('teams/create')}}"><i class="fa fa-circle-o"></i> Add Team</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-diamond"></i> <span>Project</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ asset('projects')}}"><i class="fa fa-circle-o"></i> List Project</a></li>
            <li><a href="{{ asset('projects/create')}}"><i class="fa fa-circle-o"></i> Add Project</a></li>
          </ul>
        </li>
                
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
    var url = window.location.href;
    // var path = window.location.pathname;
    $(document).ready(function () {
        $('.sidebar-menu li').each(function () {
            var href = $(this).find('a').attr('href');
            if(href == url){
                $(this).addClass('active');
                $(this).find('i').attr('class', 'fa fa-bullseye');
                $(this).parent().css('display', 'block');
                $(this).parent().parent().addClass('menu-open active');
            }
        });
    });
</script>
  