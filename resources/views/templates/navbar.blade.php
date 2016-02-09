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
        <img style="max-width:130px; margin-top: -8px" src="/img/logo2.png">
      </a>

    </div>

    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="{{ isActiveRoute('home') }}"><a href="{{ route('home') }}">Home</a></li>

        <li class="{{ isActiveRoute('search') }}"><a href="{{ route('search.index') }}">Search For Tutors</a></li>

        <li class="{{ isExactRoute('about') }}"><a href="{{ route('about.index') }}">About Us</a></li>

        <li class="{{ isActiveRoute('contact.index') }}"><a href="{{ route('contact.index') }}">Contact Us</a></li>

      </ul>



      @if(!Auth::check())
      <ul class="nav navbar-nav navbar-right">
	       <li class="{{ isExactRoute('auth/login') }}"><a href="{{ url('auth/login') }}"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
        <li class="{{ isExactRoute('auth/register') }}"><a href="{{ url('auth/register') }}"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
      </ul>

      @else
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown {{ isActiveRoute('account') }}"><a class="dropdown-toggle" data-toggle="dropdown" href="{{ url('account/showprofile') }}"><i class="fa fa-user fa-fw"></i> {{ Auth::user()->fname.' '.Auth::user()->lname }}
          <span class="caret"></span></a>
          <ul class="dropdown-menu">
            @if(Auth::user()->account_type > 1)<li class="{{ isActiveRoute('account/tutoring') }}"><a href="{{ route('tutoring.dashboard') }}"><i class="fa fa-graduation-cap fa-fw"></i> My Tutoring</a></li>@endif
            <li class="{{ isActiveRoute('account/myaccount') }}"><a href="{{ route('myaccount.dashboard') }}"><i class="fa fa-users fa-fw"></i> Dashboard</a></li>
            <li class="{{ isActiveRoute('messages.index') }}"><a href="{{ route('messages.index') }}"><i class="fa fa fa-envelope fa-fw"></i>Messages <span class="badge">{{ $message_count }}</span></a></li>
            <li class="{{ isActiveRoute('proposals.index') }}"><a href="{{ route('proposals.index') }}"><i class="fa fa fa-database fa-fw"></i>Contributing</a></li>
            <li role="separator" class="divider"></li>

            <li class="{{ isActiveRoute('account/settings') }}"><a href="{{ route('accountsettings.index') }}"><i class="fa fa-cog fa-fw"></i> Settings</a></li>
            <li><a href="{{ route('auth.logout') }}"><i class="fa fa-power-off fa-fw"></i> Logout</a></li>

          </ul>
        </li>
      </ul>
 @endif

    </div>

  </div>
</nav>
