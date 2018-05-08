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
        <li>
          <a href="/employee">
            <i class="fa fa-dashboard"></i> <span>Employees</span>
          </a>
        </li>
        <li>

          <a href="#">
            <i class="fa fa-handshake-o"></i> <span>Vendor</span>
          </a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-heartbeat"></i> <span>Team</span>
              <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ asset('employee')}}"><i class="fa fa-circle-o"></i> List Team</a></li>
            <li><a href="{{ asset('teams/create')}}"><i class="fa fa-circle-o"></i> Add Team</a></li>
          </ul>
        </li>
        <li>
          <a href="#">
            <i class="fa fa-diamond"></i> <span>Project</span>
          </a>
        </li>
                
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
  