<!-- resources/views/auth/register.blade.php -->
@extends('app')

@section('content')
<style>
.vertical-align {
  display: flex;
  align-items: center;
}
</style>
<div class="container">
  @include('templates/feedback')
  <div class="alert alert-warning text-primary" role="alert"><p><strong><i class="fa fa-smile-o"></i> Welcome to version 4.0.</strong> After months of hard work, we have finished adding dozens of new features to improve every aspect of the site. We are eager to share our work. So just login and enjoy!</p></div>
  <div class="jumbotron">
    <div class="container">
      <img src="/img/logo2.png" class="img-responsive" />
      <!-- <h1>Lexington Tutor Exchange</h1> -->
      <h2>Hello!</h2>
      <p>This site was designed by Lexington High School seniors with the vision of connecting tutors and students across towns, schools, and disciplines. We hope that through the use of our unique site, you can give yourself a more fulfilling education. Thank you!</br><em>~The Creators</em></p>
      <center>
        <div class="btn-group">
          <a class="btn btn-success btn-lg" href="/search/index" role="button"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Find a Tutor</a>
          <a class="btn btn-primary btn-lg" href="@if(\Auth::check()) {{ route('tutoring.dashboard', ['id' => \Auth::user()->id]) }} @else {{ route('auth.login') }} @endif" role="button"><span class="glyphicon glyphicon-book" aria-hidden="true"></span> Start Tutoring</a>
        </div>
      </center>

    </div>

  </div>
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <!--<div class="panel panel-default">
      <div class="panel-body">-->

      <!-- <div class="alert alert-success" role="alert"><strong>New in V1.12:</strong> Save tutor button now works without page refresh (using ajax requests and jQuery), Crontab jobs now auto emails tutor when listing expires.</div> -->
      <div id="carousel" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
          <li data-target="#carousel" data-slide-to="0" class="active"></li>
          <li data-target="#carousel" data-slide-to="1"></li>
          <li data-target="#carousel" data-slide-to="2"></li>
          <li data-target="#carousel" data-slide-to="3"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
          <div class="item active">
            <div class="col-md-8 col-md-offset-2">
              <div class="panel panel-default box-a homestats">
                <div class="panel-body">
                  <small class="social-title" style="font-size: 42px">Members:</small>

                  <h3 class="count">
                    <span class="integers" style="font-size: 56px; margin-left: 40px">{{$stats->std_members + $stats->tutor_members}}
                    </span>
                  </h3>
                  <i class="fa-stat fa fa-users"></i>
                </div>
              </div>
            </div>
          </div>
          <div class="item">
            <div class="col-md-8 col-md-offset-2">
              <div class="panel panel-default box-b homestats">
                <div class="panel-body">
                  <small class="social-title" style="font-size: 42px">Active Tutors:</small>

                  <h3 class="count">
                    <span class="integers" style="font-size: 56px; margin-left: 40px">{{ \App\Models\Tutor\Tutor::where('tutor_active', '1')->where('profile_expiration', '>=', date("Y-m-d H:i:s"))->count() }}
                    </span>
                  </h3>
                  <i class="fa-stat fa fa-graduation-cap"></i>
                </div>
              </div>
            </div>
          </div>
          <div class="item">
            <div class="col-md-8 col-md-offset-2">
              <div class="panel panel-default box-c homestats">
                <div class="panel-body">
                  <small class="social-title" style="font-size: 42px">Tutor Searches:</small>
                  <h3 class="count"><span class="integers" style="font-size: 56px; margin-left: 40px">{{ $stats->searches }}
                  </span></h3>
                  <i class="fa-stat fa fa-search"></i>
                </div>
              </div>
            </div>
          </div>
          <div class="item">
            <div class="col-md-8 col-md-offset-2">
              <div class="panel panel-default box-d homestats">
                <div class="panel-body">
                  <small class="social-title" style="font-size: 42px">Tutor Matches:</small>
                  <h3 class="count">
                    <span class="integers" style="font-size: 56px; margin-left: 40px">{{ \App\Models\TutorContact\TutorContact::count() }}
                    </span>
                  </h3>
                  <i class="fa-stat fa fa-envelope"></i>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Controls -->
        <a class="left carousel-control" style="background-image:none" href="#carousel" role="button" data-slide="prev">
          <span class="glyphicon glyphicon-chevron-left" style="color: black" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" style="background-image:none" href="#carousel" role="button" data-slide="next">
          <span class="glyphicon glyphicon-chevron-right" style="color: black" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="panel panel-success">
        <div class="panel-heading">
          <i class="fa fa-plus fa-fw"></i> New Features
        </div>
        <div class="panel-body">
          <ul>
            <li>New Bootstrap theme!</li>
            <li>Improved search function</li>
            <li>Revamped town/school/class/etc heirarchy</li>
            <li>New <a href="/LextutorexchangeTermsofUse.pdf" target="_blank">Terms of Use</a> and <a href="/LextutorexchangePrivacyPolicy.pdf" target="_blank">Privacy Policy</a>.</li>
            <li>Improved professional/standard tutor differentiation</li>
            <li>Scheduling function in search and tutoring dashboard</li>
            <li>Google Maps API for more accurate distance calculations in search</li>
          </ul>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="panel panel-warning">
        <div class="panel-heading">

          <i class="fa fa-wrench fa-fw"></i> Future Features

        </div>
        <div class="panel-body">
          <ul>
            <li>Inbuilt messaging</li>
            <li>Online payment system</li>
            <li>Multi-town support</li>
            <li>Satisfaction guarranteed or your money back on tutoring sessions paid for through our upcoming online payment system.</li>
            <li>Crowdsourcing the addition of new schools, classes, levels, instruments, etc.</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
$(document).ready(function() {
  $('.carousel').carousel({
    interval: 3000
  })
})
</script>
@stop
