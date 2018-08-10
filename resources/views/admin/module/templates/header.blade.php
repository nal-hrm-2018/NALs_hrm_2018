  <header class="header is-flex is-align-item-center is-space-between">
    <!-- Logo -->
    <a href="{{asset('/dashboard')}}">
        <img src="{!! asset('admin/templates/images/dist/img/icon_logo.png') !!}" />
        <img src="{!! asset('admin/templates/images/dist/img/icon_name.png') !!}" />
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <div class="is-flex">
      <div class="dropdown mg-right-10">
        <a href="#" data-toggle="dropdown" aria-labelledby="dropdownMenuLink">
          <img src="{!! asset('admin/templates/images/dist/img/dropdown.png') !!}">
        </a>
        <div class="dropdown-menu dropdown-notification">
          <a class="dropdown-item" href="#"><i class="fas fa-users"></i>&nbsp;5 new members joined today</a>
          <a class="dropdown-item" href="#"><i class="fas fa-shopping-cart"></i>&nbsp;25 sales made</a>
          <a class="dropdown-item" href="#"><i class="fas fa-user"></i>&nbsp;You changed your username</a>
        </div>
      </div>
      <div class="dropdown mg-right-56">
        <a class="btn btn-info dropdown-user" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <img class="margin-img-face" alt="User Image" src="{!! asset('admin/templates/images/dist/img/face.png') !!}" />
          <span class="hidden-xs">{{Auth::user()->name}}</span>
        </a>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
          <li></li>
          <li>
            {{--<a class="dropdown-item" href="#"><i class="fas fa-info">&nbsp;</i>Update Profile</a>--}}
            <div class="pull-left dropdown-item">
              @if(Illuminate\Support\Facades\Auth::user()->is_employee === 1)
                <form action="{{asset('employee/'.Illuminate\Support\Facades\Auth::id().'/edit/')}}">
              @else
                <form action="{{asset('vendors/'.Illuminate\Support\Facades\Auth::id().'/edit/')}}">
              @endif
                  <button style="border: none; background: none;" type="submit" class="fas fa-info">{{ __(trans('common.header.update_profile')) }}</button>
                </form>
            </div>
            <div class="dropdown-item pull-right">
              <SCRIPT LANGUAGE="JavaScript">
                  function confirmAction(msg) {
                      return confirm(msg);
                  }
              </SCRIPT>
              <form action="{{route('logout')}}" id="logout-employee" onSubmit="return confirmAction('Are you sure logout?')">
                <button style="border: none; background: none;" class="fas fa-sign-out-alt" type="submit" class="btn btn-primary btn-block btn-flat">{{ __(trans('common.header.logout')) }}</button>
              </form>
            </div>
            {{--<a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt">&nbsp;</i>Logout</a>--}}
          </li>
        </ul>
      </div>
    </div>

  </header>