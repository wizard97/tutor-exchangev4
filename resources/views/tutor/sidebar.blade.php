<div class="col-xs-3 col-sm-3 col-md-2 sidebar">
  <ul class="nav nav-sidebar">
    <li class="{{ isActiveRoute('tutor/index') }}"><a href="/tutor/index"><strong><i class="fa fa-dashboard"></i> Tutoring Dashboard <span class="sr-only">(current)</span></strong></a></li>
  </ul>

  <ul class="nav nav-sidebar">
    <li class="{{ isActiveRoute('tutor/info') }}"><a href="/tutor/info">My Info</a></li>
    <li class="{{ isActiveRoute('tutor/classes') }}"><a href="/tutor/classes">My Classes</a></li>
    <li><a href="#">My Music</a></li>
    <li class="{{ isActiveRoute('tutor/myprofile') }}"><a href="/tutor/myprofile">View My Profile</a></li>
  </ul>
</div>
