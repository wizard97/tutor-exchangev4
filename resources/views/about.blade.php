@extends('app')

@section('content')
<div class="container">
  <div class="page-header">
  <h1>About Us</h1>
  </div>
@include('templates/feedback')
<p>This was a project started in late 2014 by Aaron Wisner and Matan Silver. The entire site is coded from scratch in HTML, PHP, CSS, and MySQL. We even host our own web-server. Aaron is in charge of the back-end functionality, and both Aaron and Matan share responsibility for the front-end. Currently, this site is in beta, so we are far from complete in development. We will will add a lot more. Expect weird visual formatting, and perhaps occasional functionality problems; these will get worked out as time progresses.</p>

<p>Knowing how many high schoolers want a job and many Lexington parents want to find a reliable tutor for his/her kid, we created this site to connect tutors with students who need tutoring. Especially for younger kids, we don't think parents should have to pay $100 an hour to get someone to tutor their kid in basic Algebra--Any competent high schooler can not only do it cheaper, but can connect much more with the student they are tutoring.</p>

<p>Please leave us suggestions, feedback, and bug reports by sending us a message through out contact form.</p>

<h3>Special Thanks To</h3>
<ul>
<li>Chao Li (another high schooler), for designing our logo.</li>
<li><a href="http://laravel.com/">Laravel</a></li>
<li><a href="http://www.php-login.net/">The PHP-Login Project</a></li>
<li><a href="http://getbootstrap.com/">Bootstrap</a></li>
<li><a href="http://startbootstrap.com/">Start Bootstrap</a></li>
<li><a href="https://www.datatables.net/">DataTables</a></li>
<li><a href="http://glyphicons.com/">Glyphicons</a></li>
<li><a href="http://fortawesome.github.io/Font-Awesome/">Font Awesome</a></li>
<li><a href="http://jedfoster.com/Readmore.js/">Readmore.js</a></li>
</ul>

</div>
@stop
