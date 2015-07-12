<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <!-- Include font Awesome -->
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    </head>
    <body>
      <div class="container">
        <h3>Possible Tutoring Opportunity</h3>
        <hr>
        <p>Dear {{ $tutor['fname'] }}, you have been contacted for a possible tutoring job by {{  $user['fname'].' '.$user['lname'] }} from <a href="{{ route('home') }}">Lexington Tutor Exchange</a>.
          We have forwarded the message below. Please note that they will not know your address until your reply.
        </p>
        <p>
        Sincerely,<br>
        Lexington Tutor Exchange
        </p>
          <br>
        <h4>Begin Forwarded Message</h4>
        <hr>
        <p>
        {!! nl2br($inputs['message']) !!}
      </p>
      </div>
    </body>
</html>
