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
<script>
$(document).ready(function(){
  jQuery('.readmore').readmore({collapsedHeight: 83});
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })
})
</script>

<div class="container-fluid">
  @include('templates/feedback')
  <h1 class="page-header">Dashboard</h1>

  <div class="col-md-8">

    <div class="panel panel-default">
      <div class="panel-heading">
        <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Saved Tutors
      </div>
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-striped site-datatable table-hover" id="resultsTable" role="grid" aria-describedby="resultsTable_info">
            <thead>
              <tr role="row">
                <th class="sorting_asc" tabindex="0" aria-controls="resultsTable" rowspan="1" colspan="1" aria-label="Name: activate to sort column descending" style="width: 110px;" aria-sort="ascending">Name</th>
                <th class="sorting" tabindex="0" aria-controls="resultsTable" rowspan="1" colspan="1" aria-label="Grade: activate to sort column ascending" style="width: 217px;">Grade</th>
                <th class="sorting" tabindex="0" aria-controls="resultsTable" rowspan="1" colspan="1" aria-label="Age: activate to sort column ascending" style="width: 69px;">Age</th>
                <th class="sorting" tabindex="0" aria-controls="resultsTable" rowspan="1" colspan="1" aria-label="Hourly Rate: activate to sort column ascending" style="width: 155px;">Hourly Rate</th>
                <th class="sorting" tabindex="0" aria-controls="resultsTable" rowspan="1" colspan="1" aria-label="Tutor Type: activate to sort column ascending" style="width: 177px;">Tutor Type</th>
                <th class="sorting" tabindex="0" aria-controls="resultsTable" rowspan="1" colspan="1" aria-label="Tutor Reviews: activate to sort column ascending" style="width: 184px;">Tutor Reviews</th>
                <th rowspan="1" colspan="2" aria-label="Options: perform actions on saved tutors" style="">Options</th>
              </tr>
            </thead>

            <tbody>
              @foreach($saved_tutors as $tutor)
              <tr role="row" class="clickable-row @if( $tutor->account_type > 2 ) success @endif" data-href="{{ route('search.showtutorprofile', ['id' => $tutor->user_id]) }}">
                <td class="vert-align sorting_1">{{ $tutor->fname.' '.$tutor->lname }}</td>
                <td class="vert-align">{{ $tutor->grade_name }}</td>
                <td class="vert-align">{{ $tutor->age or 'N/A' }}</td>
                <td class="vert-align">${{ $tutor->rate or 'N/A' }}</td>
                <td class="vert-align">@if($tutor->account_type == 2) Standard Tutor @else Professional Tutor @endif</td>
                <td class="vert-align">
                  <span class="text-nowrap">
                    <span style="font-size: 20px">
                      <?php
                      $star_count = floor($tutor->rating);
                      $rating_decimal = $tutor->rating - floor($tutor->rating);

                      if ($rating_decimal <= 0.2) $half_star = false;
                      elseif ($rating_decimal <= 0.7) $half_star = true;
                      else
                      {
                        $half_star = false;
                        $star_count++;
                      }
                      $empty_stars = 5 - $star_count;
                      if ($half_star) $empty_stars--;

                      for ($i = 0; $i < $star_count; $i++) echo '<i style="color: #FEC601" class="fa fa-star"></i>';
                      if ($half_star) echo '<i style="color: #FEC601" class="fa fa-star-half-o"></i>';
                      for ($i = 0; $i < $empty_stars; $i++) echo '<i style="color: #FEC601" class="fa fa-star-o"></i>';
                      ?>
                    </span>
                    (<span class="text-primary">{{ $tutor->num_reviews }}</span>)
                  </span>
                </td>
                <td class="vert-align"><a target="_blank" href="{{ route('search.showtutorprofile', ['id' => $tutor->user_id]) }}" role="button"><i class="fa fa-user fa-fw text-muted" style="font-size: 20px"></i></a><i class="fa fa-envelope fa-fw text-muted" style="font-size: 20px"></i><i class="fa fa-times text-muted" style="font-size: 20px"></i></td>
              </tr>
              @endforeach
            </tbody>

          </table>
        </div>
      </div>

    </div>

    <div class="panel panel-default">
      <div class="panel-heading">
        <i class="fa fa-comments"></i> Tutoring Inquiries
      </div>
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-striped site-datatable">
            <thead>
              <tr>
                <th>To</th>
                <th>Subject</th>
                <th>Message</th>
                <th>Date</th>
                <th>Options</th>
              </tr>
            </thead>
            <tbody>
              <tr role="row" class="odd">
                <td class="vert-align sorting_1">Aaron Wisner</td>
                <td class="vert-align">Frikkin Laravel</td>
                <td class="vert-align">halp.</td>
                <td class="vert-align">00/00/0000</td>
                <td class="vert-align"><a target="_blank" href="{{ route('search.showtutorprofile', ['id' => $tutor->user_id]) }}" role="button"><i class="fa fa-user fa-fw text-muted" style="font-size: 20px"></i></a></i><i class="fa fa-envelope fa-fw text-muted" style="font-size: 20px"></i><i class="fa fa-floppy-o text-muted" style="font-size: 20px"></i><i class="fa fa-times text-muted" style="font-size: 20px"></i></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="panel panel-default">
      <div class="panel-heading">
        <i class="fa fa-star"></i> Tutoring Reviews
      </div>
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-striped site-datatable">
            <thead>
              <tr>
                <th>Tutor</th>
                <th>Title</th>
                <th>Anonymous?</th>
                <th>Rating</th>
                <th>Review</th>
                <th>Options</th>
              </tr>
            </thead>
            <tbody>
              <tr role="row" class="odd">
                <td class="vert-align sorting_1">Aaron Wisner</td>
                <td class="vert-align">don't use this scrub</td>
                <td class="vert-align">No</td>
                <td class="vert-align"><i style="color: #FEC601" class="fa fa-star"></i><i style="color: #FEC601" class="fa fa-star"></i><i style="color: #FEC601" class="fa fa-star"></i><i style="color: #FEC601" class="fa fa-star"></i><i style="color: #FEC601" class="fa fa-star-o"></i> </td>
                <td class="vert-align">He's a no0b</td>
                <td class="vert-align"><a target="_blank" href="{{ route('search.showtutorprofile', ['id' => $tutor->user_id]) }}" role="button"><i class="fa fa-user fa-fw text-muted" style="font-size: 20px"></i></a></i><i class="fa fa-envelope fa-fw text-muted" style="font-size: 20px"></i><i class="fa fa-floppy-o text-muted" style="font-size: 20px"></i><i class="fa fa-times text-muted" style="font-size: 20px"></i></td>
              </tr>
            </tbody>
          </table>
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
  $(".clickable-row").click(function() {
    window.document.location = $(this).data("href");
  });
  $('.contact-message').readmore({
    collapsedHeight: 100,
    moreLink: '<a href="#">Expand »</a>',
    lessLink: '<a href="#">Close</a>',
  });
});
</script>
@stop
