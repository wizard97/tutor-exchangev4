@extends('app')

@section('content')
<style>

.vbottom { display: inline-block; vertical-align: text-bottom; float: none; }
@media (min-width: 992px) {
  .vertical-align {
    display: flex;
    align-items: center;
  }
}

</style>
<script>
$(document).ready(function(){
  jQuery('.readmore').readmore({
    collapsedHeight: 83,
    moreLink: '<a href="#">Read more</a>',
    lessLink: '<a href="#">Read less</a>'
  });
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })
})

</script>




<div class="container">
  <!-- pass url from php to ajax -->

  <div class="page-header">
    <h1>Search Results</h1>
  </div>
  @include('templates/feedback')

  <!-- echo out the system feedback (error and success messages) -->
  @if(empty($results))
  <div class="alert alert-warning" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <i class="fa fa-frown-o"></i> <strong>Sorry! </strong>We were not able to find a match for you. Perhaps broaden your search criteria and/or check back in a week or two. Would you like to <a href="/search/index" class="alert-link">Search Again</a>?
  </div>
  @endif
  <div class="row" style="margin-bottom: 10px">
    <span class="h4">We found you {{ $num_results }} possible tutor(s):</span>
    <div class="dropdown " style="display: inline;">
      <button class="btn btn-default dropdown-toggle" type="button" id="sort-by" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
        Sort By
        <span class="caret"></span>
      </button>
      <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
        @foreach($sort_options as $option => $option_name)
        <li @if($sort_by == $option) class="active" @endif><a href="{{ \Request::url().'?sort='.$option }}">{{ $option_name }}</a></li>
        @endforeach
      </ul>
    </div>
  </div>
  @foreach($results as $tutor)
  <div class="row">
    <div  class="well">
      <div class="row vertical-align">
        <div class=" col-xs-12 col-sm-2 col-md-2">
          <div class="row">
            <a target="_blank" href="{{ route('search.showtutorprofile', ['id' => $tutor->user_id]) }}"><img src="{{ route('profileimage.showsmall', ['id' => $tutor->user_id]) }}" class="img-rounded center-block" height="120" width="120" /></a>
          </div>
          <div class="row">
            <div class="text-center" style="font-size: 20px">
              <span style="font-size: 20px" class="text-nowrap">
                {!! print_stars($tutor->avg_rating) !!}
              </span>
              (<span style="font-size: 16px"><a href="{{ route('search.showtutorprofile', ['id' => $tutor->user_id]) }}" target="_blank">{{ \App\Tutor::findOrFail($tutor->user_id)->reviews()->count() }}</a></span>)
            </div>
          </div>
        </div>

        <div class="col-xs-12 col-sm-3 col-md-4">
          <div class="row">
            <h3 style="margin-top: 0px; display:inline;">@if($tutor->account_type > 2)<span class="text-success"><i class="fa fa-user-plus" aria-hidden="true"></i> {{ $tutor->fname.' '.$tutor->lname }}</span> @else <i class="fa fa-user" aria-hidden="true"></i> {{ $tutor->fname.' '.$tutor->lname }} @endif
            </h3>
            <span class="text-muted" style="white-space: nowrap"><i class="fa fa-map-marker"></i> {{ ucwords(strtolower($tutor->city)).', '.$tutor->state_prefix }}</span>
          </div>
          <div class="row">
            <strong class="text-warning">Grade: </strong><span class="text-muted">{{ $tutor->grade_name }}</span>

          </div>

          <div class="row">
            <div class="readmore">
              <p>{{ $tutor->about_me }}</p>
            </div>
          </div>
        </div>
        <div class="col-xs-12 col-sm-3 col-md-3">
          <div class="row">
            <h3 class="text-center">Smart Match</h3>
          </div>
          <div class="row">
            <div class="col-xs-2 col-xs-offset-2 col-sm-3 col-sm-offset-1">
              <span class="label label-info">Proximity</span>
            </div>
            <div class="col-xs-6 col-xs-offset-0 col-sm-6 col-sm-offset-1">
              <div class="progress">
                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="{{ $tutor->distance_match }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $tutor->distance_match }}%; min-width: 3em;">
                  {{ $tutor->distance }} mi.
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-2 col-xs-offset-2 col-sm-3 col-sm-offset-1">
              <span class="label label-warning">Schedule</span>
            </div>
            <div class="col-xs-6 col-xs-offset-0 col-sm-6 col-sm-offset-1">
              <div class="progress">
                <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="{{ $tutor->times_match }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $tutor->times_match }}%; min-width: 3em;">
                  {{ $tutor->availability_count }}/{{$num_availability}}
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xs-12 col-sm-4 col-md-3">
          <div class="row">
            <div class="text-center">
              <strong><i class="fa fa-usd text-success" style="font-size: 46px;"></i><p class="text-success" style="font-size:46px; display: inline-block; margin-bottom:0px">{{ $tutor->rate }}</p><span class="text-muted" style="font-size: 28px;">/hour</span></strong>
            </div>
          </div>
          <div class="row">
            <div class="text-center">
              <div class="btn-group-sm" role="group" aria-label="..." style="white-space: nowrap;">
                <a class="btn btn-success btn-sm" target="_blank" href="{{ route('search.showtutorprofile', ['id' => $tutor->user_id]) }}" role="button"><i class="fa fa-user" aria-hidden="true"></i> Profile</a>
                <button class="btn btn-primary btn-sm contact-button" data-toggle="modal" data-target="#contactModal" data-userid="{{ $tutor->user_id }}"><i class="fa fa-envelope" aria-hidden="true"></i> Contact</button>
                @if(!is_null(Auth::user()->saved_tutors()->find($tutor->user_id)))
                <button type="button" name="saved_tutor_id" data-userid="{{ $tutor->user_id }}" class="btn btn-info btn-sm tutor-save-btn" aria-expanded="false"><i class="fa fa-minus" aria-hidden="true"></i> Remove</button>
                @else
                <button type="button" name="saved_tutor_id" data-userid="{{ $tutor->user_id }}" class="btn btn-warning btn-sm tutor-save-btn" aria-expanded="false"><i class="fa fa-plus" aria-hidden="true"></i> Save</button>
                @endif
              </div>
            </div>
          </div>
          @if(in_array($tutor->user_id, $tutor_contacts))
          <div class='row'><div class='text-center'><i class='fa fa-comments-o' style='font-size: 22px;' data-toggle='tooltip' data-placement='bottom' title='You have contacted this tutor before.'></i></div></div>
          @endif
        </div>
      </div>
    </div>
  </div>
  @endforeach

  @if(!empty($results))
  {!! $paginator->render() !!}
  @endif

  @include('/search/contactmodal')
</div>
@stop
