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
  @include('templates/feedback')
  <h1 class="page-header">Dashboard</h1>
  @include('templates/feedback')
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

  <div class="col-md-4">
    <div class="well well">
      <h3>Welcome Matan,</h3>
      <p>This is your account dashboard, use it to help manage your account.</p>
    </div>
    <div class="panel panel-danger">
      <div class="panel-heading">
        <i class="fa fa-bell fa-fw"></i> Notifications
      </div>
      <div class="panel-body">
        <p class="text text-muted bg-warning"><span class="text text-danger">Attention:</br></span>we now have an updated <a href="/LextutorexchangePrivacyPolicy.pdf" target="_blank">Privacy Policy</a> and <a href="/LextutorexchangeTermsofUse.pdf" target="_blank">Terms of Use</a>. We advise that you read these documents, as your use of this websites constitutes your agreement to these terms. Thank you, </br>The Creators</p>

      </div>
    </div>
  </div>
</div>
<script>
$( document ).ready(function() {

var $reviews = $('#reviews');
var getReviews = "{{route('myaccount.ajaxtutorreviews')}}";
$reviews.dataTable( {
  ajax: getReviews,
  columns: [{"title": 'Tutor', "data": null, "defaultContent": null, createdCell: function(td, cellData, rowData, row, col) {
    $(td).html(rowData.fname + ' ' + rowData.lname);
  }},
  {"title": 'Title', "data": null, "defaultContent": null, createdCell: function(td, cellData, rowData, row, col) {
    $(td).html('<span class="readmore">' + rowData.title + "</span>");
    $(".readmore").readmore({
      collapsedHeight: 41,
      moreLink: '<a href="#">Read more</a>',
      lessLink: '<a href="#">Read less</a>'
    });
  }},
  {"title": 'Rating', orderable: false, "data": null, "defaultContent": null, createdCell: function (td, cellData, rowData, row, col) {
    $(td).empty();
    var string = "";
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
    $(td).append(string);
    $.ajax({
      type: "GET",
      url : "{{ route('myaccount.ajaxtutorreviews') }}",
      success: function (data){

      }
    });
  }
},
{"title": 'Body', "data": null, "defaultContent": null, createdCell: function(td, cellData, rowData, row, col) {
  $(td).html('<span class="readmore">' + rowData.message + '</span>');
  $(".readmore").readmore({
    collapsedHeight: 83,
    moreLink: '<a href="#">Read more</a>',
    lessLink: '<a href="#">Read less</a>'
  });
}},
{"title": 'Options', orderable: false, "data": null, createdCell: function(td, cellData, rowData, row, col) {
  $(td).addClass('text-center');
  var profileLink = ("{{ route('search.showtutorprofile', ['id' => '0']) }}" + rowData.tutor_id);
  if (rowData.saved == 'TRUE') {
    $(td).html('<a href="javascript:void(0)"><i style="font-size: 20px;" class="fa fa-fw fa-times text-danger"></i></a><a href=' + profileLink + ' target="_blank"><i style="font-size: 20px;" class="fa fa-fw fa-user text-primary"></i></a>'
    + '<a href="javascript:void(0)"><i style="font-size: 20px" class="fa fa-fw fa-envelope text-primary" data-toggle="modal" data-target="#contactModal" data-userid=' + rowData.tutor_id + '></i></a>');
  }
  else {
    $(td).html('<a href="javascript:void(0)"><i style="font-size: 20px;" class="fa fa-fw fa-plus text-success"></i></a><a href=' + profileLink + ' target="_blank"><i style="font-size: 20px;" class="fa fa-fw fa-user text-primary"></i></a>'
    + '<a href="javascript:void(0)"><i style="font-size: 20px" class="fa fa-fw fa-envelope text-primary" data-toggle="modal" data-target="#contactModal" data-userid=' + rowData.tutor_id + '></i></a>');
  }
}}]
});
var getContacts = "{{route('myaccount.ajaxtutorcontacts')}}";
var $contacts = $('#contacts');
$contacts.dataTable( {
  ajax: getContacts,
  columns: [{"title": 'To', "data": null, "defaultcontent": null, createdCell: function (td, cellData, rowData, row, col){
    $(td).html(rowData.fname + ' ' + rowData.lname);
  }},
  {"visible": false, "title": "Tutor ID", "data": null, "defaultContent": null, createdCell: function (td, cellData, rowData, row, col) {
    $(td).html('<span class="readmore">' + rowData.tutor_id + "</span>");
    $(".readmore").readmore({
      collapsedHeight: 41,
      moreLink: '<a href="#">Read more</a>',
      lessLink: '<a href="#">Read less</a>'
    });
  }},
  {"title": 'Subject', "data": null, "defaultContent": null, createdCell: function (td, cellData, rowData, row, col) {
    $(td).html('<span class="readmore">' + rowData.subject + "</span>");
    $(".readmore").readmore({
      collapsedHeight: 41,
      moreLink: '<a href="#">Read more</a>',
      lessLink: '<a href="#">Read less</a>'
    });
  }},
  {"title": 'Message', "data": null, "defaultContent": null, createdCell: function (td, cellData, rowData, row, col) {
    $(td).html('<span class="readmore">' + rowData.message + '</span>');
    $(".readmore").readmore({
      collapsedHeight: 41,
      moreLink: '<a href="#">Read more</a>',
      lessLink: '<a href="#">Read less</a>'
    });

  }},
  {"title": 'Date', "data": null, "defaultContent": null, createdCell: function (td, cellData, rowData, row, col) {
    var date = new Date(rowData.created_at);
    $(td).html(date.toLocaleDateString());
  }},
  {"title": 'Options', "data": null, orderable: false, createdCell: function (td, cellData, rowData, row, col) {
    $(td).addClass('text-center');
    var profileLink = ("{{ route('search.showtutorprofile', ['id' => '0']) }}" + rowData.tutor_id);
    if (rowData.saved == 'TRUE') {
      $(td).html('<a href="javascript:void(0)"><i style="font-size: 20px;" class="fa fa-fw fa-times text-danger"></i></a><a href=' + profileLink + ' target="_blank"><i style="font-size: 20px;" class="fa fa-fw fa-user text-primary"></i></a>'
      + '<a href="javascript:void(0)"><i style="font-size: 20px" class="fa fa-fw fa-envelope text-primary" data-toggle="modal" data-target="#contactModal" data-userid=' + rowData.tutor_id + '></i></a>');
    }
    else {
      $(td).html('<a href="javascript:void(0)"><i style="font-size: 20px;" class="fa fa-fw fa-plus text-success"></i></a><a href=' + profileLink + ' target="_blank"><i style="font-size: 20px;" class="fa fa-fw fa-user text-primary"></i></a>'
      + '<a href="javascript:void(0)"><i style="font-size: 20px" class="fa fa-fw fa-envelope text-primary" data-toggle="modal" data-target="#contactModal" data-userid=' + rowData.tutor_id + '></i></a>');
    }
  }
}
]
});
var $saved_tutors = $('#saved_tutors');
var getSavedTutors = "{{route('myaccount.ajaxsavedtutors')}}";
$saved_tutors.dataTable( {

  ajax: getSavedTutors,
  columns: [{"title": 'Name', "data": null, "defaultContent": null, createdCell: function(td, cellData, rowData, row, col) {
    $(td).html(rowData.fname + ' ' + rowData.lname);
  }},
  {"visible": false, "title": "Tutor ID", "data": "tutor_id"},
  {"title": 'Grade', "data": 'grade_name'},
  {"title": 'Age', "data": null, "defaultContent": null, createdCell: function (td, celldata, rowData, row, col) {
    if (rowData.age == null)
    {
      $(td).html(rowData.age + ' years');
    }
    else
    {
      $(td).html('N/A');
    }
  }},
  {"title": 'Hourly Rate', "data": null, "defaultContent": null, createdCell: function (td, cellData, rowData, row, col) {
    $(td).html(rowData.rate + ' $/hr');
  }},
  {"title": 'Tutor Type', "data": null, "defaultContent": null, createdCell: function (td, cellData, rowData, row, col) {
    if (rowData.account_type == 3)
    {
      $(td).html('Professional');
    }
    else {
      $(td).html('Standard');
    }
  }},
  {"title": 'Rating', "data": null, "defaultContent": null, createdCell: function (td, cellData, rowData, row, col) {
    $(td).empty();
    var string = "";
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
    string += ' <span style = "font-size: 20px">(<a href = "javascript:void(0)">' + rowData.num_reviews + '</a>)</span>';
    $(td).append(string);
  }},
  {"title": 'Options', "data": null, orderable: false, createdCell: function (td, cellData, rowData, row, col) {
    $(td).addClass('text-center');
    var profileLink = ("{{ route('search.showtutorprofile', ['id' => '0']) }}" + rowData.tutor_id);
    $(td).html('<a href="javascript:void(0)"><i style="font-size: 20px;" class="fa fa-fw fa-times text-danger"></i></a><a href=' + profileLink + ' target="_blank"><i style="font-size: 20px;" class="fa fa-fw fa-user text-primary"></i></a>'
    + '<a href = "javascript:void(0)"><i style="font-size: 20px;" class="fa fa-fw fa-envelope text-primary" data-toggle="modal" data-target="#contactModal" data-userid=' + rowData.tutor_id + '></i></a>');
  }
}]
});
$(".clickable-row").click(function() {
  window.document.location = $(this).data("href");
});
$('.contact-message').readmore({
  collapsedHeight: 100,
  moreLink: '<a href="#">Expand »</a>',
  lessLink: '<a href="#">Close</a>',
});


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
    }
  });
  $.ajax({
    type: "GET",
    url : "{{ route('feedback') }}",
    success: function (data){
      $("#feedback").replaceWith(function() {
        return $(data).hide().fadeIn('slow');
      });

    }
  });
});


$('#contacts').on('click', 'i.fa-times, i.fa-plus', function () {
  var $clicked_row = $(this).closest('tr');
  var $icon = $clicked_row.find("i.fa");
  var data = $contacts.DataTable().row($clicked_row).data();


  $saved_tutors.DataTable().ajax.reload();
  $contacts.DataTable().ajax.reload();
  $reviews.DataTable().ajax.reload();

  $.ajax({
    type: "POST",
    url : "{{route('myaccount.ajaxsavetutor')}}",
    data : {user_id: data.tutor_id},
    success : function(data){
      $saved_tutors.DataTable().ajax.reload();
      $contacts.DataTable().ajax.reload();
      $reviews.DataTable().ajax.reload();
    }
  });
  $.ajax({
    type: "GET",
    url : "{{ route('feedback') }}",
    success: function (data){
      $("#feedback").replaceWith(function() {
        return $(data).hide().fadeIn('slow');
      });

    }
  });
});
$('#reviews').on('click', 'i.fa-times, i.fa-plus', function () {
  var $clicked_row = $(this).closest('tr');
  var $icon = $clicked_row.find("i.fa");
  var data = $reviews.DataTable().row($clicked_row).data();


  $saved_tutors.DataTable().ajax.reload();
  $contacts.DataTable().ajax.reload();
  $reviews.DataTable().ajax.reload();

  $.ajax({
    type: "POST",
    url : "{{route('myaccount.ajaxsavetutor')}}",
    data : {user_id: data.tutor_id},
    success : function(data){
      $saved_tutors.DataTable().ajax.reload();
      $contacts.DataTable().ajax.reload();
      $reviews.DataTable().ajax.reload();
    }
  });
  $.ajax({
    type: "GET",
    url : "{{ route('feedback') }}",
    success: function (data){
      $("#feedback").replaceWith(function() {
        return $(data).hide().fadeIn('slow');
      });

    }
  });
});


$(document).on("lex:contact_submit", function() {
  $contacts.DataTable().ajax.reload();
});

});
</script>
@include("/search/contactmodal")
@stop
