@extends('app')

@section('content')

<div class="container">
<style>
#price-slider .slider-selection {
   background: #BABABA;
 }
</style>
  <div class="page-header">
    <h1>School Tutoring <small>First we need some info...</small></h1>
  </div>
  <!--
  <div class="alert alert-info" role="alert">
  <p>Before we can show you relevant tutors, we first need some more info about what you need hlep in.</p>
  </div>
-->
@include('templates/feedback')
<br>
<br>


<div class="col-lg-offset-2 col-lg-8">
  <form class="form" id="search-form" method="POST" action="{{ route('school.submitsearch') }}">
    {!! csrf_field() !!}
    <div class="row">
    <div id="rootwizard">
      	<ul style="font-size: 20px; margin-bottom: 10px;">
      	  	<li><a href="#tab1" data-toggle="tab"><i class="fa fa-location-arrow fa-fw no-red"></i> Location</a></li>
      		<li><a href="#tab2" data-toggle="tab"><i class="fa fa-university fa-fw no-red"></i> Grade</a></li>
      		<li><a href="#tab3" data-toggle="tab"><i class="fa fa-graduation-cap fa-fw no-red"></i> Tutor</a></li>
      		<li><a href="#tab4" data-toggle="tab"><i class="fa fa-money fa-fw no-red"></i> Pricing</a></li>
      		<li><a href="#tab5" data-toggle="tab"><i class="fa fa-calendar fa-fw no-red"></i> Schedule</a></li>
      	</ul>

        <div class="progress">
          <div id="bar" class="progress-bar progress-bar-striped active" role="progressbar">
          </div>
        </div>

      	<div class="tab-content well">

      	    <div class="tab-pane" id="tab1">
                <h3 class="text-center">Locations and Distances</h3>
                <br>

                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-offset-3 col-md-6">
                        <label>Max Tutor Distance</label><br>
                        <b>1 Mile</b> <input name="max_dist" class="form-control" id="dist-slider" type="number" data-slider-scale="logarithmic" data-slider-value="10" data-slider-min="1" data-slider-max="200" data-slider-step="1"/> <b>200 Miles</b>
                      </div>
                      </div>
                  </div>

                <div class="form-group">
                  <div class="row">
                    <div class="col-md-offset-3 col-md-6 col-sm-offset-2 col-sm-8 col-xs-offset-0 col-xs-12">
                      @if(Auth::check())
                      <label>Your Address (<a href="{{ route('accountsettings.index') }}">edit</a>)</label>
                      <input name="address" class="form-control" id="address" placeholder="Address" value="{{Auth::user()->address}}" disabled>
                      @else
                      <label>Your Zip Code</label>
                      <input name="zip" class="form-control" id="zip" placeholder="Enter your zip code">
                      @endif
                    </div>
                  </div>
                </div>
      	    </div>

      	    <div class="tab-pane" id="tab2">
              <h3 class="text-center">Student Grade</h3>
              <br>
              <div class="row">
        	      <div class="col-md-offset-2 col-md-8">
                  <button class="btn btn-info btn-lg btn-block school-selection" value="middle" type="button">Student <span style="font-size: 20px;">&le;</span> Middle School</button>
                  <button class="btn btn-warning btn-lg btn-block school-selection" value="high" type="button">Student <span style="font-size: 20px;">&ge;</span> High School</button>
                  <input type="hidden" name="school_type">
                </div>
              </div>
              <div class="clearfix"></div>
      	    </div>

      		<div class="tab-pane" id="tab3">
            <h3 class="text-center">Professional or Standard Tutor?</h3>
            <br>
            <div class="row">
              <div class="col-md-offset-2 col-md-8">
                <button class="btn btn-default btn-lg btn-block tutor-selection" type="button" value="standard"><i class="fa fa-user fa-fw"></i> Standard</button>
                <button class="btn btn-success btn-lg btn-block tutor-selection" type="button" value="professional"><i class="fa fa-user-plus fa-fw"></i> Professional</button>
                <input type="hidden" name="tutor_type">
              </div>
            </div>
            <div class="clearfix"></div>
      	  </div>

      		<div class="tab-pane" id="tab4">
            <h3 class="text-center">Price Range</h3>
            <br>
            <div class="row">
              <div class="col-md-offset-2 col-md-8 text-center">
                <b>$0 /hour</b> <input id="price-slider" type="text" class="form-control" value="" data-slider-id='price-slider' data-slider-min="0" data-slider-max="200" data-slider-step="5" data-slider-value="[10,100]"/> <b>$200 /hour</b>
              <input type="hidden" name="start_rate" value="10">
              <input type="hidden" name="end_rate" value="100">
              </div>
            </div>
            <div class="clearfix"></div>
      	  </div>

      		<div class="tab-pane" id="tab5">
            <h3 class="text-center">Your Availability</h3>

            <div class="col-lg-offset-2 col-lg-8">
                <table class="table table-condensed">
                  <thead>
                    <tr>
                      <th class="text-center text-primary">Day</th>
                      <th class="text-center text-primary">Ideal Time</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $days = ['mon' => 'Monday', 'tues' => 'Tuesday', 'wed' => 'Wednesday', 'thurs' => 'Thursday', 'fri' => 'Friday', 'sat' => 'Saturday', 'sun' => 'Sunday']; ?>

                    @foreach($days as $key => $day)
                    <tr class="time-row">
                      <td>
                        <div class="checkbox row-checkbox">
                          <label>
                            <input type="checkbox" value="1" name="{{$key}}_checked"> {{ $day }}
                          </label>
                        </div>
                      </td>

                      <td>
                        <div class="input-group clockpicker">
                          <input type="text" class="form-control" value="03:00PM" name="{{$key}}">
                          <span class="input-group-addon">
                            <span class="glyphicon glyphicon-time"></span>
                          </span>
                        </div>
                      </td>

                    </tr>
                    @endforeach
                  </tbody>
                </table>
            </div>
            <div class="clearfix"></div>
      	  </div>

      		<ul class="pager wizard">
      			<li class="previous no-red"><a href="#">Previous</a></li>
      		  <li class="next no-red"><a href="#">Next</a></li>
            <li class="next finish no-red" style="display:none;"><a href="#" type="submit">Next</a></li>
      		</ul>

      	</div>
      </div>

    </div>
  </form>
</div>

<script>
$(document).ready(function() {

  	$('#rootwizard').bootstrapWizard({
      tabClass: 'nav nav-pills',
      onTabShow: function(tab, navigation, index) {
		      var $total = navigation.find('li').length;
		      var $current = index+1;
		      var $percent = Math.round(($current/$total) * 100);
		      $('#rootwizard').find('#bar').css({width:$percent+'%'}).text($percent+'%');

      		// If it's the last tab then hide the last button and show the finish instead
      		if($current >= $total) {
      			$('#rootwizard').find('.pager .next').hide();
      			$('#rootwizard').find('.pager .finish').show();
      			$('#rootwizard').find('.pager .finish').removeClass('disabled');
      		} else {
      			$('#rootwizard').find('.pager .next').show();
      			$('#rootwizard').find('.pager .finish').hide();
      		}
      	},
        /*
      onNext: function(tab, navigation, index) {
			    if(index==2) {
  				  // Make sure we entered the name
  				  if(!$('#zip').val()) {
    					alert('You must enter your name');
    					$('#name').focus();
    					return false;
  				  }
			    }
      }
      */

      });

//prevent redirects
  $('.no-red').click(function(e) {
    e.preventDefault();
      });

$('#price-slider').slider({
	formatter: function(value) {
		return '$' + value[0] + ' - $' + value[1] + ' /hour';
	}
});

$('#dist-slider').slider({
	formatter: function(value) {
		return value + ' Miles';
	}
});

$("#price-slider").on("change", function(data) {
  $(this).siblings("input[name='price_start']").val(data.value.newValue[0]);
  $(this).siblings("input[name='price_end']").val(data.value.newValue[1]);

});

$('.clockpicker').clockpicker({
  align: 'top',
  donetext: 'Done',
  twelvehour: true,
  });

$('.time-row .checkbox input').change(function(){
  if ($(this).is(':checked'))
  {
    $(this).closest('.time-row').addClass('success');
  }
  else $(this).closest('.time-row').removeClass('success');
});

$('.school-selection').click(function() {
  var $button = $(this);
  $button.addClass('active').siblings().removeClass('active');
  $button.siblings('input').val($button.val());
});

$('.tutor-selection').click(function() {
  var $button = $(this);
  $button.addClass('active').siblings().removeClass('active');
  $button.siblings('input').val($button.val());
});

$('#rootwizard .finish').click(function() {
$("#search-form").submit();
});

$('.time-row .checkbox input').each(function(){
  if ($(this).is(':checked'))
  {
    $(this).closest('.time-row').addClass('success');
  }
  else $(this).closest('.time-row').removeClass('success');
});

});
</script>
</div>
@stop
