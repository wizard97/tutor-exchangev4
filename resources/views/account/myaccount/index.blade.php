@extends('app')

@section('content')
<style>
@media (min-width: 992px) {
  .vertical-align {
    display: flex;
    align-items: center;
  }
}
</style>
<div class="container-fluid">
  <h1 class="page-header">Dashboard</h1>
  @include('templates/feedback')
  <div class="col-md-4">
    <div class="well well">
      <h3>Welcome {{ \Auth::user()->fname }},</h3>
      <p>This is your account dashboard, use it to help manage your account.</p>
    </div>
    <div class="panel panel-danger">
      <div class="panel-heading">
        <i class="fa fa-bell fa-fw"></i> Notifications
      </div>
      <div class="panel-body">
        <p class="text bg-warning"><span class="text text-danger">Attention:</br></span>We now have an updated <a href="/LextutorexchangePrivacyPolicy.pdf" target="_blank">Privacy Policy</a> and <a href="/LextutorexchangeTermsofUse.pdf" target="_blank">Terms of Use</a>. We advise that you read these documents, as your use of this website constitutes your agreement to these terms. Thank you, </br>The Creators</p>

      </div>
    </div>
  </div>
  <div class="col-md-8">
    <div class="panel panel-default">
      <div class="panel-heading">
        <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Saved Tutors
      </div>
      <div class="panel-body">
        <div class="table-responsive">
          <table id="saved_tutors" class="table table-striped table-bordered table-hover"></table>
        </div>
      </div>

    </div>

    <div class="panel panel-default">
      <div class="panel-heading">
        <i class="fa fa-comments"></i> Tutoring Inquiries
      </div>
      <div class="panel-body">
        <div class="table-responsive">
          <table id="contacts" class="table table-striped table-bordered table-hover"></table>
        </div>
      </div>
    </div>

    <div class="panel panel-default">
      <div class="panel-heading">
        <i class="fa fa-star"></i> Tutoring Reviews
      </div>
      <div class="panel-body">
        <div class="table-responsive">
          <table id="reviews" class="table table-striped table-bordered table-hover"></table>
        </div>
      </div>

    </div>


  </div>


</div>
<script>
$( document ).ready(function() {
  var $saved_tutors = $('#saved_tutors');
  var getSavedTutors = "{{route('myaccount.ajaxsavedtutors')}}";
  $saved_tutors.DataTable(
    {

      ajax: getSavedTutors,
      columns:
      [
        {
          "title": 'Name', "data": "fname", "defaultContent": null, createdCell: function(td, cellData, rowData, row, col)
          {
            if((rowData.fname != null) && (rowData.lname != null))
            {
              $(td).html(rowData.fname + ' ' + rowData.lname);

            }
            else
            {
              $(id).html('N/A');
            }
          }
        },
        {
          "visible": false, "title": "Tutor ID", "data": "tutor_id"},
          {
            "title": 'Grade', "data": 'grade_name'},
            {
              "title": 'Age', "data": "age", "defaultContent": null, createdCell: function (td, celldata, rowData, row, col)
              {
                if (rowData.age != null)
                {
                  $(td).html(rowData.age + ' years');

                }
                else
                {
                  $(td).html('N/A');
                }
              }
            },
            {
              "title": 'Hourly Rate', "data": "rate", "defaultContent": null, createdCell: function (td, cellData, rowData, row, col)
              {
                if (rowData.rate != null)
                {
                  $(td).html(rowData.rate + ' $/hr');

                }
                else
                {
                  $(td).html('N/A');
                }

              }
            },
            {
              "title": 'Tutor Type', "data": "account_type", "defaultContent": null, createdCell: function (td, cellData, rowData, row, col)
              {
                if (rowData.account_type != null)
                {
                  if (rowData.account_type == 3)
                  {
                    $(td).html('Professional');
                  }
                  else {
                    $(td).html('Standard');
                  }
                }
                else
                {
                  $(td).html('N/A');
                }
              }
            },
            {
              "title": 'Rating', "data": "rating", "defaultContent": null, createdCell: function (td, cellData, rowData, row, col)
              {
                if(rowData.rating != null)
                {
                  $(td).empty();
                  var string = "<span class='text-nowrap'>";
                  var star_count = Math.floor(rowData.rating);
                  for (var i = 0; i < star_count; i++)
                  {
                    string += "<i style='color: #FEC601; font-size: 20px' class='fa fa-star'></i>";
                  }
                  var delta = rowData.rating - star_count;
                  if (delta >= 0.25)
                  {
                    if (delta < 0.75)
                    {
                      string += "<i style='color: #FEC601; font-size: 20px' class='fa fa-star-half-o'></i>";
                    }
                    else
                    {
                      string += "<i style='color: #FEC601; font-size: 20px' class='fa fa-star'></i>";
                    }
                    for (var i = 0; i < 4 - star_count; i++)
                    {
                      string += "<i style='color: #FEC601; font-size: 20px' class='fa fa-star-o'></i>";
                    }
                  }
                  else
                  {
                    for (var i = 0; i < 5 - star_count; i++)
                    {
                      string += "<i style='color: #FEC601; font-size: 20px' class='fa fa-star-o'></i>";
                    }
                  }
                  string += ' <span style = "font-size: 20px">(<a href = "javascript:void(0)">' + rowData.num_reviews + '</a>)</span></span>';
                  $(td).append(string);
                }
                else
                {
                  $(td).html('N/A');
                }
              }
            },
            {
              "title": 'Options', "data": null, "defaultContent": null, orderable: false, createdCell: function (td, cellData, rowData, row, col)
              {
                $(td).addClass('text-center');
                var profileLink = ("{{ route('search.showtutorprofile', ['id' => '0']) }}" + rowData.tutor_id);
                $(td).html('<span class="text-nowrap"><a href="javascript:void(0)"><i style="font-size: 20px;" class="fa fa-fw fa-times text-danger"></i></a><a href=' + profileLink + ' target="_blank"><i style="font-size: 20px;" class="fa fa-fw fa-user text-primary"></i></a>'
                + '<a href = "javascript:void(0)"><i style="font-size: 20px;" class="fa fa-fw fa-envelope text-primary" data-toggle="modal" data-target="#contactModal" data-userid=' + rowData.tutor_id + '></i></a></span>');
              }
            }
          ]
        }
      );

      var getContacts = "{{route('myaccount.ajaxtutorcontacts')}}";
      var $contacts = $('#contacts');
      $contacts.DataTable(
        {
          ajax: getContacts,
          columns: [
            {
              "title": 'To', "data": "fname", "defaultcontent": null, createdCell: function (td, cellData, rowData, row, col)
              {
                if ((rowData.fname != null) && (rowData.lname != null))
                {
                  $(td).html(rowData.fname + ' ' + rowData.lname);
                }
                else
                {
                  $(td).html('N/A');
                }
              }
            },
            {
              "title": 'Subject', "data": "subject", "defaultContent": null, createdCell: function (td, cellData, rowData, row, col)
              {
                if (rowData.subject != null)
                {
                  $info = $('<div class="readmore"><p></p></div>');
                  $info.find('p').text(rowData.subject);
                  $(td).html($info[0].outerHTML);
                }
                else
                {
                  $(td).html('N/A');
                }
              }
            },
            {
              "title": 'Message', "data": "message", "defaultContent": null, createdCell: function (td, cellData, rowData, row, col)
              {
                if (rowData.message != null)
                {
                  $info = $('<div class="readmore"><p></p></div>');
                  $info.find('p').text(rowData.message);
                  $(td).html($info[0].outerHTML);
                }
                else
                {
                  $(td).html('N/A');
                }
              }
            },
            {
              "title": 'Date', "data": "created_at", "defaultContent": null, createdCell: function (td, cellData, rowData, row, col)
              {
                if (rowData.created_at != null)
                {
                  var date = new Date(rowData.created_at);
                  $(td).html(date.toLocaleDateString());
                }
                else
                {
                  $(td).html('N/A');
                }
              }
            },
            {
              "title": 'Options', "data": null, "defaultContent": null, orderable: false, createdCell: function (td, cellData, rowData, row, col)
              {
                $(td).addClass('text-center');
                var profileLink = ("{{ route('search.showtutorprofile', ['id' => '0']) }}" + rowData.tutor_id);
                if (rowData.saved == 'TRUE') {
                  $(td).html('<span class="text-nowrap"><a href="javascript:void(0)"><i style="font-size: 20px;" class="fa fa-fw fa-times text-danger"></i></a><a href=' + profileLink + ' target="_blank"><i style="font-size: 20px;" class="fa fa-fw fa-user text-primary"></i></a>'
                  + '<a href="javascript:void(0)"><i style="font-size: 20px" class="fa fa-fw fa-envelope text-primary" data-toggle="modal" data-target="#contactModal" data-userid=' + rowData.tutor_id + '></i></a></span>');
                }
                else {
                  $(td).html('<span class="text-nowrap"><a href="javascript:void(0)"><i style="font-size: 20px;" class="fa fa-fw fa-plus text-success"></i></a><a href=' + profileLink + ' target="_blank"><i style="font-size: 20px;" class="fa fa-fw fa-user text-primary"></i></a>'
                  + '<a href="javascript:void(0)"><i style="font-size: 20px" class="fa fa-fw fa-envelope text-primary" data-toggle="modal" data-target="#contactModal" data-userid=' + rowData.tutor_id + '></i></a></span>');
                }
              }
            }
          ]

        }
      );
      var $reviews = $('#reviews');
      var getReviews = "{{route('myaccount.ajaxtutorreviews')}}";
      $reviews.DataTable(
        {
          ajax: getReviews,
          columns: [
            {
              "title": 'Tutor', "data": "fname", "defaultContent": null, createdCell: function(td, cellData, rowData, row, col)
              {
                if ((rowData.fname != null) && (rowData.lname != null))
                {
                  $(td).html(rowData.fname + ' ' + rowData.lname);
                }
                else
                {
                  $(td).html('N/A');
                }
              }
            },
            {
              "title": 'Title', "data": "title", "defaultContent": null, createdCell: function(td, cellData, rowData, row, col)
              {
                if (rowData.title != null)
                {
                  $info = $('<div class="readmore"><p></p></div>');
                  $info.find('p').text(rowData.title);
                  $(td).html($info[0].outerHTML);
                }
                else
                {
                  $(td).html('N/A');
                }
              }
            },
            {
              "title": 'Rating', orderable: false, "data": "rating", "defaultContent": null, createdCell: function (td, cellData, rowData, row, col)
              {
                if (rowData.rating != null)
                {
                  $(td).empty();
                  var string = "<span class='text-nowrap'>";
                  var star_count = Math.floor(rowData.rating);
                  for (var i = 0; i < star_count; i++)
                  {
                    string += "<i style='color: #FEC601; font-size: 20px' class='fa fa-star'></i>";
                  }
                  var delta = rowData.rating - star_count;
                  if (delta >= 0.25)
                  {
                    if (delta < 0.75)
                    {
                      string += "<i style='color: #FEC601; font-size: 20px' class='fa fa-star-half-o'></i>";
                    }
                    else
                    {
                      string += "<i style='color: #FEC601; font-size: 20px' class='fa fa-star'></i>";
                    }
                    for (var i = 0; i < 4 - star_count; i++)
                    {
                      string += "<i style='color: #FEC601; font-size: 20px' class='fa fa-star-o'></i>";
                    }
                  }
                  else
                  {
                    for (var i = 0; i < 5 - star_count; i++)
                    {
                      string += "<i style='color: #FEC601; font-size: 20px' class='fa fa-star-o'></i>";
                    }
                  }
                  string += '</span>';
                  $(td).append(string);
                  $.ajax({
                    type: "GET",
                    url : "{{ route('myaccount.ajaxtutorreviews') }}",
                    success: function (data){

                    }
                  });
                }
                else
                {
                  $(td).html('N/A');
                }
              }
            },
            {
              "title": 'Body', "data": "message", "defaultContent": null, createdCell: function(td, cellData, rowData, row, col)
              {
                if (rowData.message != null)
                {
                  $info = $('<div class="readmore"><p></p></div>');
                  $info.find('p').text(rowData.message);
                  $(td).html($info[0].outerHTML);
                }
                else
                {
                  $(td).html('N/A');
                }
              }
            },
            {
              "title": 'Options', orderable: false, "data": null, "defaultContent": null, createdCell: function(td, cellData, rowData, row, col)
              {
                $(td).addClass('text-center');
                var profileLink = ("{{ route('search.showtutorprofile', ['id' => '0']) }}" + rowData.tutor_id);
                if (rowData.saved == 'TRUE') {
                  $(td).html('<span class="text-nowrap"><a href="javascript:void(0)"><i style="font-size: 20px;" class="fa fa-fw fa-times text-danger"></i></a><a href=' + profileLink + ' target="_blank"><i style="font-size: 20px;" class="fa fa-fw fa-user text-primary"></i></a>'
                  + '<a href="javascript:void(0)"><i style="font-size: 20px" class="fa fa-fw fa-envelope text-primary" data-toggle="modal" data-target="#contactModal" data-userid=' + rowData.tutor_id + '></i></a></span>');
                }
                else {
                  $(td).html('<span class="text-nowrap"><a href="javascript:void(0)"><i style="font-size: 20px;" class="fa fa-fw fa-plus text-success"></i></a><a href=' + profileLink + ' target="_blank"><i style="font-size: 20px;" class="fa fa-fw fa-user text-primary"></i></a>'
                  + '<a href="javascript:void(0)"><i style="font-size: 20px" class="fa fa-fw fa-envelope text-primary" data-toggle="modal" data-target="#contactModal" data-userid=' + rowData.tutor_id + '></i></a></span>');
                }
              }
            }
          ]

        }
      );
      $(".clickable-row").click(function() {
        window.document.location = $(this).data("href");
      });
      $contacts.on( 'draw.dt', function () {
        $(this).find("td .readmore").readmore({
          collapsedHeight: 41,
          moreLink: '<a href="#">Read more</a>',
          lessLink: '<a href="#">Read less</a>'
        });
      } );
      $reviews.on( 'draw.dt', function () {
        $(this).find("td .readmore").readmore({
          collapsedHeight: 41,
          moreLink: '<a href="#">Read more</a>',
          lessLink: '<a href="#">Read less</a>'
        });
      } );


      $('#saved_tutors').on('click', 'i.fa-times', function () {
        var $clicked_row = $(this).closest('tr');
        var data = $saved_tutors.DataTable().row($clicked_row).data();
        $.ajax({
          type: "POST",
          url : "{{route('myaccount.ajaxsavetutor')}}",
          data : {user_id: data.tutor_id},
          success : function(data){
            $saved_tutors.DataTable().row($clicked_row).remove();
            $saved_tutors.DataTable().ajax.reload();
            $contacts.DataTable().ajax.reload();
            $reviews.DataTable().ajax.reload();
            $.ajax({
              type: "GET",
              url : "{{ route('feedback') }}",
              success: function (data){
                $("#feedback").replaceWith(function() {
                  return $(data).hide().fadeIn('slow');
                });

              }
            });
          }
        });

      });


      $('#contacts').on('click', 'i.fa-times, i.fa-plus', function () {
        var $clicked_row = $(this).closest('tr');
        var $icon = $clicked_row.find("i.fa");
        var data = $contacts.DataTable().row($clicked_row).data();


        $.ajax({
          type: "POST",
          url : "{{route('myaccount.ajaxsavetutor')}}",
          data : {user_id: data.tutor_id},
          success : function(data){
            $saved_tutors.DataTable().ajax.reload();
            $contacts.DataTable().ajax.reload();
            $reviews.DataTable().ajax.reload();
            $.ajax({
              type: "GET",
              url : "{{ route('feedback') }}",
              success: function (data){
                $("#feedback").replaceWith(function() {
                  return $(data).hide().fadeIn('slow');
                });

              }
            });
          }
        });

      });
      $('#reviews').on('click', 'i.fa-times, i.fa-plus', function () {
        var $clicked_row = $(this).closest('tr');
        var $icon = $clicked_row.find("i.fa");
        var data = $reviews.DataTable().row($clicked_row).data();

        $.ajax({
          type: "POST",
          url : "{{route('myaccount.ajaxsavetutor')}}",
          data : {user_id: data.tutor_id},
          success : function(data){
            $saved_tutors.DataTable().ajax.reload();
            $contacts.DataTable().ajax.reload();
            $reviews.DataTable().ajax.reload();
            $.ajax({
              type: "GET",
              url : "{{ route('feedback') }}",
              success: function (data){
                $("#feedback").replaceWith(function() {
                  return $(data).hide().fadeIn('slow');
                });

              }
            });
          }
        });

      });
      $(document).on("lex:contact_submit", function() {
        $contacts.DataTable().ajax.reload();
      });
      $(window).load(function(){
        //your code here
        $(".readmore").readmore();


      });
      });




  </script>
  @include("/search/contactmodal")
  @stop
