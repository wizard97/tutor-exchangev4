<!-- resources/views/auth/register.blade.php -->
@extends('app')

@section('content')
<div class="container">
<div class="page-header">
  <h1>Search Results</h1>
</div>

@include('templates/feedback')

@if(empty($results))
<div class="alert alert-warning" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <i class="fa fa-frown-o"></i> <strong>Sorry! </strong>We were not able to find a match for you. Perhaps broaden your search criteria and/or check back in a week or two. Would you like to <a href="/search/index" class="alert-link">Search Again</a>?</div>
@endif

<div class="table-responsive">
  <table class="table table-striped" id="resultsTable">
    <caption>We found you {{ $num_results }} possible tutor(s):</caption>

    <thead>
    <tr>
        <th>Picture</th>
        <th>Name</th>
        <th>Grade</th>
        <th>Age</th>
        <th>Hourly Rate</th>
        <th>Tutor Type</th>
        <th>Percent Match</th>
        <th>Reviews</th>
        <th>Options</th>

    </tr>
  </thead>

  <tbody>
    @foreach($results as $tutor)

    @if($tutor->account_type > 2) <tr class="success">
    @else <tr>
    @endif

    <td class="vert-align">
      <a target="_blank" href="{{ route('search.showtutorprofile', ['id' => $tutor->user_id]) }}"><img src="{{ route('profileimage.showsmall', ['id' => $tutor->user_id]) }}" class="img-rounded" height="50" width="50" /></a>
    </td>

    <td class="vert-align">
      <a href="{{ route('search.showtutorprofile', ['id' => $tutor->user_id]) }}">
      {{ $tutor->fname.' '.$tutor->lname}}
    </a>
    </td>

    <td class="vert-align">
      {{ $tutor->grade_name }}
    </td>

    <td class="vert-align">
      {{ $tutor->age or N/A }}
    </td>

    <td class="vert-align">
      ${{ $tutor->rate }}
    </td>

    <td class="vert-align">
      @if($tutor->account_type > 2) Professional Tutor
      @else Standard Tutor
      @endif
    </td>

    <td class="vert-align">
      <div class="progress vert-align">
        <div class="progress-bar progress-bar-primary
        @if($tutor->percent_match > 60) progress-bar-primary
        @elseif($tutor->percent_match > 30) progress-bar-warning
        @else progress-bar-danger
        @endif
        " role="progressbar" aria-valuenow="{{ $tutor->percent_match }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $tutor->percent_match }}%">{{ $tutor->percent_match }}%
      </div>
    </div>
    </td>

    <td class="vert-align">
      <span class="text-nowrap">
        <span style="font-size: 18px">
@for($i = 0; $i < $tutor->star_count; $i++)<i style="color: #FEC601" class="fa fa-star"></i>@endfor
@if($tutor->half_star)<i style="color: #FEC601" class="fa fa-star-half-o"></i>@endif
@for($i = 0; $i < $tutor->empty_stars; $i++)<i style="color: #FEC601" class="fa fa-star-o"></i>@endfor
        </span>
       (<span class="text-primary"><a href="{{ route('search.showtutorprofile', ['id' => $tutor->user_id]) }}">{{ $tutor->num_reviews }}</a></span>)
     </span>
    </td>

    <td class="vert-align">
      <a class="btn btn-success btn-sm" target="_blank" href="{{ route('search.showtutorprofile', ['id' => $tutor->user_id]) }}" role="button">
        <span class="glyphicon glyphicon-user" aria-hidden="true"></span> Profile
      </a>

      <button class="btn btn-primary btn-sm contact-button" data-toggle="modal" data-target="#contactModal" data-userid="{{ $tutor->user_id }}">
        <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Contact
      </button>

      @if(in_array($tutor->user_id, $saved_tutors))
      <button type="button" name="saved_tutor_id" data-userid="{{ $tutor->user_id }}" class="btn btn-info btn-sm tutor-save-btn" aria-expanded="false"><span class="glyphicon glyphicon-floppy-saved" aria-hidden="true"></span>
        Saved!
      </button>
      @else
      <button type="button" name="saved_tutor_id" data-userid="{{ $tutor->user_id }}" class="btn btn-warning btn-sm tutor-save-btn" aria-expanded="false"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>
         Save me!
      </button>
      @endif

    </td>

  </tr>
    @endforeach
  </tbody>
</table>
</div>

@if(!empty($results))
{!! $results->render() !!}
@endif

@include('/search/contactmodal')

</div>
@stop
