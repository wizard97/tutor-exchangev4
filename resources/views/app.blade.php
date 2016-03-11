<!doctype html>
<html>
<head>
    <meta name="google-site-verification" content="x91WvPNaAdw3bjXe9VZONNcImZP-iuspmgaPee1oqpM" />
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lexington Tutor Exchange</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Latest compiled and minified CSS -->
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">-->
    <!-- Include font Awesome -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <!-- Optional theme -->
    <link rel="stylesheet" href="/css/flatlytheme.css">
    <!-- Data Tables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.css">

    <!-- Dashboard CSS -->
    <link rel="stylesheet" href="/css/dashboard.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">

    <!-- Typeahead CSS -->
    <link rel="stylesheet" href="/css/typeahead.css">

    <!-- bootstrap Slider CSS -->
    <link rel="stylesheet" href="/css/bootstrap-slider.css">

    <!-- Clockpicker CSS -->
    <link rel="stylesheet" href="/css/clockpicker.css">

    <!-- Star Rating CSS -->
    <link rel="stylesheet" href="/css/star-rating.min.css">

    <link rel="stylesheet" href="/css/bootstrap-wysiwyg.css">


    <!-- jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

    <!-- Bootstrap Tables-->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.8.1/bootstrap-table.min.css">


    <!-- Latest compiled and minified JavaScript -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.8.1/bootstrap-table.min.js"></script>

    <!-- DataTables -->
    <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.js"></script>
    <!-- Needer for Bootstrap Datatables-->
    <script src="https://cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.js"></script>

    <!-- Typeahead -->
    <script src="/js/typeahead.bundle.js"></script>

    <!-- Bootstrap Wizard -->
    <script src="/js/bootstrap.wizard.min.js"></script>

    <!-- Bootstrap Slider -->
    <script src="/js/bootstrap-slider.js"></script>

    <!-- Clockpicker -->
    <script src="/js/clockpicker.js"></script>

    <!-- Star Rating -->
    <script src="/js/star-rating.min.js"></script>

    <!-- Needer for Coutnerup -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js"></script>
    <!-- Review box JS -->
    <script src="/js/reviewbox.js"></script>
    <!-- Readmore JS -->
    <script src="/js/readmore.js"></script>
    <!-- counterupJS -->
    <script src="/js/counterup.js"></script>

    <script src="/js/jquery.hotkeys.js"></script>

    <script src="/js/bootstrap-wysiwyg.min.js"></script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

    <script src="/js/bootstrap-tagsinput.js"></script>

    <link rel="stylesheet" href="/css/bootstrap-tagsinput.css">
    <link rel="stylesheet" href="/css/bootstrap-tagsinput-typeahead.css">-

    <style type="text/css">
    .table tbody>tr>td.vert-align{
        vertical-align: middle;
    }
    body { padding-bottom: 150px;}

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
    //lextutor functions
    var lte = {
        //retrieve feedback messages
        feedback: function() {
            //to advoid race conditions
            setTimeout( function(){
                $.ajax({
                    type: "GET",
                    url : "{{ route('feedback') }}",
                    success: function (data){
                        $("#feedback").replaceWith(function() {
                            return $(data).hide().fadeIn('slow');
                        });
                    }
                });
            }, 100);
        },

        //print form validation errors
        validation_errors: function validation_errors(response, selector)
        {
            if( response.status === 401 ) //redirect if not authenticated user.
            {
                $( location ).prop( 'pathname', 'auth/login' );
            }
            else if( response.status === 422 ) {
                //process validation errors here.
                $errors = response.responseJSON; //this will get the errors response data.
                //show them somewhere in the markup
                //e.g
                errorsHtml = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4><i class="fa fa-info-circle"></i> Watch out! </h4><ul>';

                $.each( $errors, function( key, value ) {
                    errorsHtml += '<li>' + value[0] + '</li>'; //showing only the first error.
                });
                errorsHtml += '</ul></div>';

                $( selector ).hide().html( errorsHtml ).fadeIn('slow'); //appending to a <div id="form-errors"></div> inside form
            } else {
                alert('There was an unexspected error, please let us know if this problem persists.');
            }
        }
    };




    //runs when page is loaded
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.site-datatable').dataTable();

        //save button
        $(".tutor-save-btn").on("click", function(){
            var button = $(this);
            var id = button.data('userid'); // Extract info from data-* attributes
            var url = "{{ route('myaccount.ajaxsavetutor') }}";
            //save
            $.ajax({
                type: "POST",
                url : url,
                data : {user_id: id},
                success : function(data){

                    if(data[id] === true)
                    {
                        button.toggleClass('btn-success', false).toggleClass('btn-danger', true);
                        button.hide().html('<i class="fa fa-minus" aria-hidden="true"></i> Remove').fadeIn('slow');
                    }
                    else
                    {
                        button.toggleClass('btn-success', true).toggleClass('btn-danger', false);
                        button.hide().html('<i class="fa fa-plus" aria-hidden="true"></i> Save').fadeIn('slow');
                    }
                    //get feedback messages
                    lte.feedback();
                }

            });
        });



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


    });

    </script>


    <script>
    $(document).ready(function(){
        $(".integers").counterUp({delay: 10,time: 1000});


    });
    </script>
    <style>
    .homestats{
        position: relative;
        transform: translateY(9%);
    }
    .row.vertical-divider {
        overflow: hidden;
    }
    .row.vertical-divider > div[class^="col-"] {
        text-align: center;
        padding-bottom: 100px;
        margin-bottom: -100px;
        border-left: 3px solid #F2F7F9;
        border-right: 3px solid #F2F7F9;
    }
    .row.vertical-divider div[class^="col-"]:first-child {
        border-left: none;
    }
    .row.vertical-divider div[class^="col-"]:last-child {
        border-right: none;
    }
    </style>
</head>

<body>
    @include('templates/navbar')
    @yield('content')
    @include('templates/footer')
</body>

</html>
