<div class="col-xs-3 col-sm-3 col-md-2 sidebar">

  <ul class="nav nav-sidebar">
    <li class="{{ isActiveRoute('tutoring.dashboard') }}"><a href="{{route('tutoring.dashboard')}}"><strong><i class="fa fa-dashboard"></i> Tutoring Dashboard</strong></a></li>
    <li class="{{ isActiveRoute('tutoring.info') }}"><a href="{{route('tutoring.info')}}">My Info</a></li>
    <li class="{{ isActiveRoute('tutoring.classes') }}"><a href="{{route('tutoring.classes')}}">My Classes</a></li>
    <li class="disabled"><a href="#">My Music <span class="label label-info">Coming Soon</span></a></li>
    <li class="{{ isActiveRoute('tutoring.myprofile') }}"><a href="{{route('tutoring.myprofile')}}">View My Profile</a></li>
  </ul>

  <ul class="nav nav-sidebar">
      <li class=""><a href="/tutor/index"><strong><i class="fa fa-cog"></i> Tutoring Settings</strong></a></li>

  </ul>
</div>
