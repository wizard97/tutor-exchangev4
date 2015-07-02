<nav class="navbar navbar-inverse navbar-fixed-top">
<div class="container-fluid">
    <div class="navbar-header">

      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>

  <!--    <a class="navbar-brand" href="{{ url('home') }}"><i class="fa fa-exchange"></i> Lexington Tutor Exchange</a> -->

      <a class="navbar-brand" rel="home" href="/home" title="Lexington Tutor Exchange">
        <img style="max-width:130px; margin-top: -8px;" src="/img/logo.png">
      </a>

    </div>

    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="{{ isActiveRoute('home') }}"><a href="{{ url('home') }}">Home</a></li>

        @if(Auth::check())
          <li class="dropdown {{ isActiveRoute('search') }}">
          <a class="dropdown-toggle" data-toggle="dropdown" href="{{ url('search/index') }}">Search for Tutors
          <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li class="{{ isExactRoute('search/index') }}"><a href="{{ url('search/index') }}">Search Form</a></li>
            <li class="{{ isExactRoute('search/saved') }}"><a href="{{ url('search/saved') }}">My Saved Tutors</a></li>
            </ul>
            </li>
            @else
              <li class="{{ isActiveRoute('search') }}"><a href="{{ url('search/index') }}">Search For Tutors</a></li>
            @endif


        <li class="{{ isExactRoute('about') }}"><a href="{{ url('about') }}">About Us</a></li>
        <li class="{{ isExactRoute('contact') }}"><a href="{{ url('contact') }}">Contact Us</a></li>

        @if(Auth::check() && Auth::user()->account_type >= 2)
        <li class="{{ isActiveRoute('tutor') }}"><a href="{{ url('tutor/index') }}">My Tutoring</a></li>
        @endif

        @if(Auth::check())
        <li class="dropdown {{ isActiveRoute('account') }}"><a class="dropdown-toggle" data-toggle="dropdown" href="{{ url('account/showprofile') }}">Account Settings
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
        <li><a href="{{ url('account/showprofile') }}">My Account</a></li>
        <li class="{{ isExactRoute('') }}"><a href="">Change Account Type</a></li>
        <li class="{{ isExactRoute('') }}"><a href="">Profile Picture</a></li>
        <li class="{{ isExactRoute('') }}"><a href="">Edit Name</a></li>
        <li class="{{ isExactRoute('') }}"><a href="">Edit Email</a></li>
        <li class="{{ isExactRoute('') }}"><a href="{{ url('auth/logout') }}">Logout</a></li>
        </ul>
        </li>
        @endif

      </ul>

      @if(!Auth::check())
      <ul class="nav navbar-nav navbar-right">
	       <li class="{{ isExactRoute('auth/login') }}"><a href="{{ url('auth/login') }}"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
        <li class="{{ isExactRoute('auth/register') }}"><a href="{{ url('auth/register') }}"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
      </ul>

@else
      <ul class="nav navbar-nav navbar-right">
       <li class="{{ isExactRoute('auth/logout') }}"><a href="{{ url('auth/logout') }}"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
      </ul>
 @endif

    </div>
  </div>

</nav>
