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
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
      <!-- Include font Awesome -->
      <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
      <!-- Optional theme -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

      <!-- Dashboard CSS -->
      <link rel="stylesheet" href="/css/dashboard.css">

      <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">

      <!-- jquery -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
      <!-- Latest compiled and minified JavaScript -->
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

      <!-- Needer for Coutnerup -->
      <script src="//cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js"></script>
      <!-- Review box JS -->
      <script src="/js/reviewbox.js"></script>
      <!-- Readmore JS -->
      <script src="/js/readmore.js"></script>
      <!-- counterupJS -->
      <script src="/js/counterup.js"></script>

      <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>

     <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

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

<script>

//runs when page is loaded
$(document).ready(function() {
    //expand and collapse large texts
    $('.about_me').readmore({
        collapsedHeight: 200,
        moreLink: '<a href="#">Read more</a>',
        lessLink: '<a href="#">Read less</a>',
        embedCSS: true,
        startOpen: false
    });
    $('.review').readmore({
        collapsedHeight: 200,
        moreLink: '<a href="#">Read more</a>',
        lessLink: '<a href="#">Read less</a>',
        embedCSS: true,
        startOpen: false
    });

    //to save tutors
    $(".text-center").on("click", "button.btn, #save_btn", function() {
        var $button = $(this);
        var id = $button.val();
        var url = $("#url").val();
        var $html = "";
        $.post(url, {
            'saved_tutors_id[]': [id]
        }, function(data) {
            var json = $.parseJSON(data);
            if (json[id] === true) {
                $html = $(
                    '<button type="button" id="save_btn" name="saved_tutors_id[]" value="" class="btn btn-info" aria-expanded="false"><span class="glyphicon glyphicon-floppy-saved" aria-hidden="true"></span> Saved!</button>'
                );
                $button.replaceWith($html);
                $html.val(id);
            } else {
                $html = $(
                    '<button type="button" id="save_btn" name="saved_tutors_id[]" value="" class="btn btn-warning" aria-expanded="false"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Save me!</button>'
                );
                $button.replaceWith($html);
                $html.val(id);
            }
            var url_feed = $("#url_feedback").val();
            $.ajax(url_feed, {
                success: function(data) {
                    //remove old feedback messages
                    $(".alert").remove();
                    $(".page-header").after(
                        data);
                }
            });
        });
    });
});

</script>


<script>
$(document).ready(function(){
  $(".integers").counterUp({delay: 10,time: 1000});
    $('#resultsTable').dataTable();

});
</script>


  </head>

  <body>
    @include('templates/navbar')
        @yield('content')
    @include('templates/footer')
  </body>

</html>
