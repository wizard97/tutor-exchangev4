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
      <!-- /.panel-heading -->
      <div class="panel-body">
      </div>
      <!-- /.panel-body -->
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
  {"title": 'Title', "data": 'title'},
  {"title": 'Rating', orderable: false, "data": null, "defaultContent": null, createdCell: function (td, cellData, rowData, row, col) {
    $(td).empty();
    var string = "";
    var star_count = Math.floor(rowData.rating);
    for (var i = 0; i < star_count; i++)
    {
      string += "<i style='color: #FEC601' class='fa fa-star'></i>";
    }
    var delta = rowData.rating - star_count;
    if (delta >= 0.25)
    {
      if (delta < 0.75)
      {
        string += "<i style='color: #FEC601' class='fa fa-star-half-o'></i>";
      }
      else
      {
        string += "<i style='color: #FEC601' class='fa fa-star'></i>";
      }
      for (var i = 0; i < 4 - star_count; i++)
      {
        string += "<i style='color: #FEC601' class='fa fa-star-o'></i>";
      }
    }
    else
    {
      for (var i = 0; i < 5 - star_count; i++)
      {
        string += "<i style='color: #FEC601' class='fa fa-star-o'></i>";
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
{"title": 'Body', "data": 'message'},
{"title": 'Options', orderable: false, "data": null, createdCell: function(td, cellData, rowData, row, col) {
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
var saved_index = -1;
$contacts.dataTable( {
  ajax: getContacts,
  columns: [{"title": 'To', "data": null, "defaultcontent": null, createdCell: function (td, cellData, rowData, row, col){
    $(td).html(rowData.fname + ' ' + rowData.lname);
  }},
  {"visible": false, "title": "Tutor ID", "data": "tutor_id"},
  {"visible": false, "title": "saved_index", "data": saved_index},
  {"title": 'Subject', "data": 'subject'},
  {"title": 'Message', "data": 'message'},
  {"title": 'Date', "data": null, "defaultContent": null, createdCell: function (td, cellData, rowData, row, col) {
    var date = new Date(rowData.created_at);
    $(td).html(date.toLocaleDateString());
  }},
  {"title": 'Options', "data": null, orderable: false, createdCell: function (td, cellData, rowData, row, col) {
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
      string += "<i style='color: #FEC601' class='fa fa-star'></i>";
    }
    var delta = rowData.rating - star_count;
    if (delta >= 0.25)
    {
      if (delta < 0.75)
      {
        string += "<i style='color: #FEC601' class='fa fa-star-half-o'></i>";
      }
      else
      {
        string += "<i style='color: #FEC601' class='fa fa-star'></i>";
      }
      for (var i = 0; i < 4 - star_count; i++)
      {
        string += "<i style='color: #FEC601' class='fa fa-star-o'></i>";
      }
    }
    else
    {
      for (var i = 0; i < 5 - star_count; i++)
      {
        string += "<i style='color: #FEC601' class='fa fa-star-o'></i>";
      }
    }
    $(td).append(string);
  }},
  {"title": 'Options', "data": null, orderable: false, createdCell: function (td, cellData, rowData, row, col) {
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
  console.log("clicked");
  var $clicked_row = $(this).closest('tr');
  var data = $saved_tutors.DataTable().row($clicked_row).data();
  $.ajax({
    type: "POST",
    url : "{{route('myaccount.ajaxsavetutor')}}",
    data : {user_id: data.tutor_id},
    success : function(data){
      $saved_tutors.DataTable().row($clicked_row).remove();
      $saved_tutors.DataTable().draw();
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

$('#contacts').on('click', 'i.fa-times', function () {
  console.log("clicked");
  var $clicked_row = $(this).closest('tr');
  var $icon = $clicked_row.find("i.fa");
  var data = $contacts.DataTable().row($clicked_row).data();


  $saved_tutors.DataTable().draw();
  $contacts.DataTable().draw();

  console.log("saved_index = " + saved_index);
  $.ajax({
    type: "POST",
    url : "",
    data : {user_id: data.tutor_id},
    success : function(data, saved_index){
      console.log("saved_index = " + saved_index);

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



});
</script>
@include("/search/contactmodal")
@stop
