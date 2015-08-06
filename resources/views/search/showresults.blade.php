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
<caption>We found you {{ $num_results }} possible tutor(s):</caption>
@foreach($results as $tutor)
  <div class="row">

    <div  class="@if($tutor->account_type > 2) alert alert-success @else alert alert-info @endif">
      <div class="row vertical-align">
        <div class=" col-xs-12 col-sm-2 col-md-2">
          <div class="row">
            <a target="_blank" href="{{ route('search.showtutorprofile', ['id' => $tutor->user_id]) }}"><img src="{{ route('profileimage.showsmall', ['id' => $tutor->user_id]) }}" class="img-rounded center-block" height="120" width="120" /></a>
          </div>
          <div class="row">
            <div class="text-center" style="font-size: 20px">
              <span style="font-size: 20px" class="text-nowrap">
                {!! print_stars(\App\Tutor::findOrFail($tutor->user_id)->reviews()->avg('rating')) !!}
              </span>
              (<span style="font-size: 16px"><a href="{{ route('search.showtutorprofile', ['id' => $tutor->user_id]) }}">{{ \App\Tutor::findOrFail($tutor->user_id)->reviews()->count() }}</a></span>)
            </div>
          </div>
        </div>
        <div class="col-xs-12 col-sm-3 col-md-4">
          <div class="row" style="margin-bottom: 10px;">
            <h3 style="margin-top: 0px; display:inline;" data-toggle="tooltip" data-placement="top" title="{{ $tutor->grade_name }}"><i class="fa fa-user" aria-hidden="true"></i>{{ ' '.$tutor->fname.' '.$tutor->lname }}
            </h3>
            <span class="text-muted"><i class="fa fa-map-marker"></i> {{ ucfirst(strtolower($tutor->city)).','.$tutor->state }}</span>
          </div>
          <div class="row">
            <div class="readmore">
              <p>{{ $tutor->about_me }}</p>
            </div>
          </div>
        </div>
        <div class="col-xs-12 col-sm-3 col-md-3">
          <div class="row">
            <h3 class="text-center">Percent Match</h3>
          </div>
          <div class="row">
            <div class="col-xs-2 col-xs-offset-2 col-sm-3 col-sm-offset-1">
              <span class="label label-success">Classes</span>
            </div>
            <div class="col-xs-6 col-xs-offset-0 col-sm-6 col-sm-offset-1">
              <div class="progress">
                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{{ $tutor->classes_match }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $tutor->classes_match }}%; min-width: 3em;">
                  {{ $tutor->classes_match }}%
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-2 col-xs-offset-2 col-sm-3 col-sm-offset-1">
              <span class="label label-info">Proximity</span>
            </div>
            <div class="col-xs-6 col-xs-offset-0 col-sm-6 col-sm-offset-1">
              <div class="progress">
                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="{{ $tutor->distance_match }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $tutor->distance_match }}%; min-width: 3em;">
                  {{ $tutor->distance_match }}%
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
                  {{ $tutor->times_match }}%
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
          <div class="row">
            <div class="text-center">
              <i class="fa fa-comments-o" style="font-size: 22px;" data-toggle="tooltip" data-placement="bottom" title="You already contacted this tutor."></i>
            </div>
          </div>
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
