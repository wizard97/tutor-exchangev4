<div class="col-xs-3 col-sm-3 col-md-2 sidebar">

  <ul class="nav nav-sidebar">
    <li class="{{ isActiveRoute('tutoring.dashboard') }}"><a href="{{route('tutoring.dashboard')}}"><strong><i class="fa fa-dashboard fa-fw"></i> Tutoring Dashboard</strong></a></li>
    <li class="{{ isActiveRoute('tutoring.info') }}"><a href="{{route('tutoring.info')}}"><i class="fa fa-info fa-fw"></i> My Info</a></li>
    <li class="{{ isActiveRoute('tutoring.schedule') }}"><a href="{{route('tutoring.schedule')}}"><i class="fa fa-calendar fa-fw"></i> My Schedule</a></li>
    <li class="{{ isActiveRoute('tutoring.classes') }}"><a href="{{route('tutoring.classes')}}"><i class="fa fa-graduation-cap fa-fw"></i> My Classes</a></li>
    <li class="{{ isActiveRoute('tutoring.music') }}"><a href="{{route('tutoring.music')}}"><i class="fa fa-music fa-fw"></i> My Music</a></li>
    <li class="{{ isActiveRoute('tutoring.myprofile') }}"><a href="{{route('tutoring.myprofile')}}"><i class="fa fa-user fa-fw"></i> View My Profile</a></li>
    <li class="{{ isActiveRoute('proposals.submitschool') }}"><a href="{{route('proposals.submitschool')}}"><i class="fa fa-book fa-fw"></i> Submit/Edit School</a></li>
    <li class="{{ isActiveRoute('proposals.submitsubject') }}"><a href="{{route('proposals.submitsubject')}}"><i class="fa fa-book fa-fw"></i> Submit/Edit Subject</a></li>
    <li class="{{ isActiveRoute('proposals.submitclass') }}"><a href="{{route('proposals.submitclass')}}"><i class="fa fa-book fa-fw"></i> Submit/Edit Class/Level</a></li>

  </ul>

  <ul class="nav nav-sidebar">
    <li class=""><a href="{{ route('tutoring.settings') }}"><strong><i class="fa fa-cog"></i> Tutoring Settings</strong></a></li>

  </ul>
</div>

<div class="row">
  <div class="col-lg-7">
    <div class="visible-xs-inline">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <i class="fa fa-link fa-fw"></i> Quick Links
        </div>

        <div class="panel-body">
          <div class="btn-group btn-group-justified">

            <a class="btn btn-primary" href="{{ route('tutoring.info') }}">
              <i class="fa fa-info fa-2x"></i><br>
              Update Info
            </a>

            <a class="btn btn-primary" href="{{ route('tutoring.classes') }}">
              <i class="fa fa-graduation-cap fa-2x"></i><br>
              Update Classes
            </a>

            <a class="btn btn-primary" href=" {{ route('tutoring.music') }}">
              <i class="fa fa-music fa-2x"></i><br>
              Update Music
            </a>

            <a class="btn btn-primary" href="">
              <i class="fa fa-calendar fa-2x"></i><br>
              Update Schedule
            </a>

            <a class="btn btn-primary" href="{{ route('tutoring.myprofile') }}">
              <i class="fa fa-user fa-2x"></i><br>
              View Profile
            </a>
            <a class="btn btn-primary" href="{{ route('proposals.submitschool') }}">
              <i class="fa fa-user fa-2x"></i><br>
              Submit/Edit School
            </a>
            <a class="btn btn-primary" href="{{ route('proposals.submitsubject') }}">
              <i class="fa fa-user fa-2x"></i><br>
              Submit/Edit Subject
            </a>
            <a class="btn btn-primary" href="{{ route('proposals.submitclass') }}">
              <i class="fa fa-user fa-2x"></i><br>
              Submit/Edit Class
            </a>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
