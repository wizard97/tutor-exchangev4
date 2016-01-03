@extends('app')

@section('content')
<div class="container">

  <div class="jumbotron">
    <h1 class="text-center">About Us</h1>
    <p class="lead"><p>This was brainstormed in late 2014 by Aaron Wisner and Matan Silver during a high school lunch period senior year. The entire site runs on a Linux webserver, and is coded by hand in HTML, CSS, JavaScript, PHP, and SQL using a variety of open source projects. Aaron is in charge of the back-end functionality, and both Aaron and Matan share responsibility for the front-end. Currently, this site is in beta, so we are far from complete in development. We will will add a lot more. Expect weird visual formatting, and perhaps occasional functionality problems; these will get worked out as time progresses.</p>

    <p>Knowing how many high schoolers want a job and many Lexington parents want to find a reliable tutor for his/her kid, we created this site to connect tutors with students who need tutoring. Especially for younger kids, we don't think parents should have to pay $100 an hour to get someone to tutor their kid in basic Algebra--Any competent high schooler can not only do it cheaper, but can connect much more with the student they are tutoring.</p>

    <p>Please leave us suggestions, feedback, and bug reports by sending us a message through our <a href="{{ route('contact.index') }}">contact</a> form.</p>

  </div>

  <div class="row marketing">
    <div class="col-md-6">
      <h2>The Creators:</h2>
      <div class="alert alert-info">
        <div class="row">
          <div class="col-md-3">
            <img src="/img/Aaron.jpg" class="img-rounded center-block" height="120" width="120" >
          </div>
          <div class="clearfix col-md-9">
            <h3>Aaron Wisner</h3>
            <p>Aaron is a Freshman at Northeastern University, majoring in Electrical Engineering and Computer Science at Cornell University. He's worked as an intern at a local Lexington company called Adapteva, on a parallel processing development board. Aaron takes care of the backend for lextutorexchange, which was his brainchild in the senior year at Lexington High School.</p>
          </div>
        </div>
      </div>
      <div class="alert alert-info">
        <div class="row">
          <div class="col-md-3">
            <img src="/img/Matan.jpg" class="img-rounded center-block" height="120" width="120" >
          </div>
          <div class="col-md-9">
            <h3>Matan Silver</h3>
            <p>Matan is a Freshman at Northeastern University, studying Electrical Engineering. He has worked for the last year at <a href="http://www.fractenna.com" target="_blank">Fractal Antenna</a>, where he build wideband antennas using a fleet of seven 3D printers. He is currently interning at <a href="http://www.dangerawesome.co" target="_blank">Danger!Awesome</a>, which is a startup that does tons of awesome laser cutting/engraving, 3D printing, vinyl cutting, CNC milling, and more. In his free time, Matan plays with the 3D printer that he built at home, plays flute, and works on improving this site! He also enjoys correcting Aaron's spelling mistakes that once riddled the site... :P</p>
            <blockquote>
  <p>"Do you even code even, bruh?"</p>
  <footer>Matan Silver</footer>
</blockquote>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <h2>Special Thanks To</h2>
      <ul>
        <li>Chao Li (another high schooler), for designing our logo.</li>
        <li><a href="http://laravel.com/" target="_blank">Laravel</a></li>
        <li><a href="http://www.php-login.net/" target="_blank">The PHP-Login Project</a></li>
        <li><a href="http://getbootstrap.com/" target="_blank">Bootstrap</a></li>
        <li><a href="http://startbootstrap.com/" target="_blank">Start Bootstrap</a></li>
        <li><a href="https://www.datatables.net/" target="_blank">DataTables</a></li>
        <li><a href="http://glyphicons.com/" target="_blank">Glyphicons</a></li>
        <li><a href="http://fortawesome.github.io/Font-Awesome/" target="_blank">Font Awesome</a></li>
        <li><a href="http://jedfoster.com/Readmore.js/" target="_blank">Readmore.js</a></li>
        <li><a href="https://developers.google.com/maps/web/" target="_blank">Google Maps API</a></li>
      </ul>
    </div>

    @include('templates/feedback')

  </div>

</div>
@stop
