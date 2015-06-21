<!doctype html>
<html>
  <head>
      <meta name="google-site-verification" content="x91WvPNaAdw3bjXe9VZONNcImZP-iuspmgaPee1oqpM" />
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>Lexington Tutor Exchange, Exclusively For Lexington MA Tutoring</title>
      <meta name="description" content="">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- Latest compiled and minified CSS -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

      <!-- Optional theme -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
      <!-- jquery -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
      <!-- Latest compiled and minified JavaScript -->
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

      <style type="text/css">
.table tbody>tr>td.vert-align{
    vertical-align: middle;
}
body { padding-bottom: 100px; }

.btn { white-space: normal; }

.social-title {text-transform: uppercase; letter-spacing: 1px; }
.count { font-size: 37px;margin-top: 10px;margin-bottom: 10px; }
.fa-stat { font-size: 100px;text-align: right;position: absolute;top: 7px;right: 27px;outline: none; }
.social .panel { color:#fff;text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5); }
.social a { text-decoration:none; }
.box-a { background-color:#00acee; }
.box-b { background-color:#dd4b39; }
.box-c { background-color:#3b5998; }
.box-d { background-color:#eb6d20; }
</style>

  </head>

  <body>
    @include('templates/navbar')
      <div class="container">
        @yield('content')
      </div>
      @include('templates/footer')
  </body>

</html>
