  <header class="main-header">
    <!-- Logo -->
    <a href="{{asset('/dashboard')}}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>N</b>ALs</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>NALs</b>HRM</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" style="padding:0;">
      <!-- Sidebar toggle button-->
      <a href="#" style="height: 50px;" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>


      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav" style="     flex-direction: row;">
          <li>
            <div class="languages" style="margin-top:12px;">
              <a href="{{route('setlanguaes','en')}}" lang="en" title="{{trans('common.language.en')}}">
                {{ Html::image('admin/templates/images/Localization/en.png', 'a picture', [
              'class' => 'thumb',
              'id'=>app()->getLocale()===config('settings.locale.en')?'language_active':'inactive',
              'title'=>trans('common.language.en'),
              'lang'=>'en',
              'style'=>app()->getLocale()===config('settings.locale.en')?'padding:0px 2px;border:1px solid white':'',
              'height'=>'25'
              ]) }}
              </a>
              <a href="{{route('setlanguaes','vn')}}" lang="vn" title="{{trans('common.language.vn')}}">
                {{ Html::image('admin/templates/images/Localization/vi.png', 'a picture', [
              'class' => 'thumb',
              'id'=>app()->getLocale()===config('settings.locale.vn')?'language_active':'inactive',
              'title'=>trans('common.language.vn'),
              'style'=>app()->getLocale()===config('settings.locale.vn')?'padding:0px 2px;border:1px solid white':'',
              'lang'=>'vn',
              'height'=>'25'
              ]) }}
              </a>
            </div>
          </li>
          <!-- Notifications: style can be found in dropdown.less -->

          {{-- <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="glyphicon glyphicon-bell" style="font-size: 15px;"></i>
              <span class="label label-warning">10</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 10 notifications</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-aqua"></i> 5 new members joined today
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
                      page and may cause design problems
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-red"></i> 5 new members joined
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-user text-red"></i> You changed your username
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">View all</a></li>
            </ul>
          </li> --}}
          
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img class="user-image" alt="User Image" src="@if(isset(Auth::user()->avatar))
              {{asset('/avatar/'.Auth::user()->avatar)}}
              @else
              {{asset('/avatar/default_avatar.png')}}
              @endif" />
              <span class="hidden-xs">{{trans('common.header.welcome')}} {{Auth::user()->name}}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">

                <img src="@if(isset(Auth::user()->avatar))
                {{asset('/avatar/'.Auth::user()->avatar)}}
                @else
                {{asset('/avatar/default_avatar.png')}}
                @endif" class="img-circle" alt="User Image">

                <p>
                  {{Auth::user()->name}} - {{isset(App\Models\Employee::where('id', Auth::user()->id)->first()->employeeType->name)?App\Models\Employee::where('id', Auth::user()->id)->first()->employeeType->name:"  "  }}
                  <small>{{trans('common.header.member_since')}}
                      <?php
                      $date = new DateTime(Auth::user()->startwork_date);
                      echo $date->format('d-m-Y');
                      ?>
                  </small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer" >
                <div class="pull-left">
                  @if(Illuminate\Support\Facades\Auth::user()->is_employee === 1)
                    <form action="{{asset('employee/'.Illuminate\Support\Facades\Auth::id().'/edit/')}}">
                  @else
                    <form action="{{asset('vendors/'.Illuminate\Support\Facades\Auth::id().'/edit/')}}">
                  @endif                  
                    <button type="submit" class="btn btn-default btn-block btn-flat">{{ __(trans('common.header.update_profile')) }}</button>
                  </form>
                </div>

                <div class="pull-right">

                  <SCRIPT LANGUAGE="JavaScript">
                      function confirmAction(msg) {
                          return confirm(msg);
                      }
                  </SCRIPT>
                  <form action="{{route('logout')}}" id="logout-employee" onsubmit="return confirm_logout();">
                    <button type="submit" class="btn btn-default btn-block btn-flat">{{ __(trans('common.header.logout')) }}</button>
                  </form>

                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->          
        </ul>
      </div>
    </nav>
  </header>
  <script type="text/javascript">
    function confirm_logout(){
       return confirm(message_confirm('{{trans("common.header.confirm_logout")}}', '{{trans("common.account")}}', ""));
    }
  </script>