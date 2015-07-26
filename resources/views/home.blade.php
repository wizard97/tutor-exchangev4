<!-- resources/views/auth/register.blade.php -->
@extends('app')

@section('content')
<div class="container">
@include('templates/feedback')
<div class="jumbotron">
  <div class="container">
  <div class="col-md-8">
    <img src="/img/logo2.png" class="img-responsive" />
 <!-- <h1>Lexington Tutor Exchange</h1> -->
    <h2>Hello, Lexington MA!</h2>
    <p>This site was designed by Lexington students for Lexington students. We will find the best tutor for you based on pricing, subject, and tutor level. This site welcomes both student and professional tutor signups.</p>
    <p>
    <a class="btn btn-success btn-lg" href="/search/index" role="button"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Find a Tutor</a>
    <a class="btn btn-primary btn-lg" href="@if(\Auth::check()) {{ route('tutoring.dashboard', ['id' => \Auth::user()->id]) }} @else {{ route('auth.login') }} @endif" role="button"><span class="glyphicon glyphicon-book" aria-hidden="true"></span> Start Tutoring</a>
    </px>
  </div>

  <div class="col-md-4 hidden-sm hidden-xs">
  <img  width="300" src="/img/large-logo-black.png">
  </div>
<!--
<div class="col-md-4 hidden-sm hidden-xs">
<h1><i class="fa fa-exchange fa-5x"></i></h1>
</div>
-->
  </div>
</div>

<!-- <div class="alert alert-success" role="alert"><strong>New in V1.12:</strong> Save tutor button now works without page refresh (using ajax requests and jQuery), Crontab jobs now auto emails tutor when listing expires.</div> -->

<div class="row social">

    <div class="col-sm-6 col-md-6 col-lg-3">
        <div class="panel panel-default box-a">
            <div class="panel-body">
              <small class="social-title">Members</small>
              <h3 class="count">
              <span class="integers">{{$stats->std_members + $stats->tutor_members}}
              </span></h3>
              <i class="fa-stat fa fa-users"></i>
            </div>
        </div>
      </div>

    <div class="col-sm-6 col-md-6 col-lg-3">
        <div class="panel panel-default box-b">
            <div class="panel-body">
                <small class="social-title">Active Tutors</small>
                <h3 class="count">
                <span class="integers">{{ $stats->active_tutors }}
                </span></h3>
                <i class="fa-stat fa fa-graduation-cap"></i>
            </div>
        </div>
    </div>



    <div class="col-sm-6 col-md-6 col-lg-3">
        <div class="panel panel-default box-c">
            <div class="panel-body">
                <small class="social-title">Tutor Searches</small>
                <h3 class="count"><span class="integers">{{ $stats->searches }}
                </span></h3>
                <i class="fa-stat fa fa-search"></i>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-md-6 col-lg-3">
        <div class="panel panel-default box-d">
            <div class="panel-body">
                <small class="social-title">Tutor Matches</small>
                <h3 class="count">
                <span class="integers">123
                </span></h3>
                <i class="fa-stat fa fa-envelope"></i>
            </div>
        </div>
    </div>

</div>


<div class="row">
<div class="col-md-6">
<div class="panel panel-success">
  <div class="panel-heading">
    <h3 class="panel-title"><i class="fa fa-plus"></i> Latest Features</h3>
  </div>
  <div class="panel-body" style="height: 110px">
<ul>
<li>English and foreign language tutoring</li>
<li>Crontab followup emails</li>
</ul>
  </div>
</div>
</div>

<div class="col-md-6">
<div class="panel panel-info">
  <div class="panel-heading">
    <h3 class="panel-title"><i class="fa fa-wrench"></i> Upcoming Features</h3>
  </div>
  <div class="panel-body" style="height: 110px">
  <ul>
<li>Database normalization, to more easily add classes</li>
<li>Improved tutor matching algorithm, see percentage of how well tutors match your search!</li>
<li>Play around with these new features on our <a href="http://wisner.duckdns.org:8080/index/index">BETA Test Server</a></li>
</ul>
  </div>
</div>
</div>
</div>
<div class="clearfix"></div>

<hr>

<div class="row">

            <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img src="/img/minuteman.jpg" alt="">
                    </div>
                    <div class="caption">
                        <h3>Lexington MA Only</h3>
                        <p>This site was designed exclusively for students, parents, and tutors of the Lexington Community.</p>
                        <p>
                            <a href="/about" class="btn btn-default">About Us »</a>
                        </p>
                    </div>
            </div>

            <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img src="/img/search.jpg" alt="">
                    </div>
                    <div class="caption">
                        <h3>Find The Perfect Tutor</h3>
                        <p>Just select the credentials you require in your tutor, and we will search all our listing to find you the best one. You can even rate tutors. Currently there are  tutors,  of which are active.</p>
                        <p>
                            <a href="/search/index" class="btn btn-default">Find a Tutor »</a>
                        </p>
                    </div>

            </div>

            <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img src="/img/profile.jpg" alt="">
                    </div>
                    <div class="caption">
                        <h3>Become a Tutor Yourself</h3>
                        <p>Interested in tutoring? We provide a free easy way to be found. Just register as a tutor, and complete your tutor profile. We will do the rest. Both student and professional tutors are welcome.</p>
                        <p>
                            <a href="/auth/register" class="btn btn-default">Start Tutoring »</a>
                        </p>
                    </div>

            </div>

            <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img src="/img/github.jpg" alt="">
                    </div>
                    <div class="caption">
                        <h3>Site Run & Created by LHS Students</h3>
                        <p>This entire site is hand-coded, designed, and run by Lexington High School seniors.</p>
                        <p>
                            <a href="https://github.com/wizard97/tutor-exchange" class="btn btn-default">Source Code »</a>
                        </p>
                    </div>

            </div>

        </div>
  </div>
@stop
