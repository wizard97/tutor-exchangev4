<div class="row">
  <div class="col-md-3">

    <div class="row">
      <img src="{{ route('profileimage.showfull', ['id' => $tutor->user_id]) }}" width="300" height="300" class="img-thumbnail img-responsive center-block">
    </div>

  <div class="row">
    <div class="text-center">
      @if(in_array($tutor->user_id, $saved_tutors))
      <button type="button" name="saved_tutor_id" data-userid="{{ $tutor->user_id }}" class="btn btn-info btn-sm tutor-save-btn" aria-expanded="false"><i class="fa fa-minus" aria-hidden="true"></i> Remove</button>
      @else
      <button type="button" name="saved_tutor_id" data-userid="{{ $tutor->user_id }}" class="btn btn-warning btn-sm tutor-save-btn" aria-expanded="false"><i class="fa fa-plus" aria-hidden="true"></i> Save</button>
      @endif
      <a class="btn btn-primary" data-toggle="modal" data-target="#contactModal" data-userid="{{ $tutor->user_id }}"><span class="fa fa-envelope" aria-hidden="true"></i> Contact</a>
    </div>
    <br>
  </div>

  </div>

<div class="col-md-9">
  <div class="alert alert-info">
    <h3>About Me:</h3>
    <p class="about_me">{!! nl2br($tutor->about_me) !!}</p>
  </div>
</div>
</div>


<div class="row">
  <div class="col-md-3">
    <div class="row">
      <ul class="list-group">
        <li class="list-group-item text-muted list-group-item-success" contenteditable="false">@if($tutor->account_type == 2) <i class="fa fa-user"></i> Standard Tutor @elseif ($tutor->account_type == 3) <i class="fa fa-user-plus"></i> Professional Tutor @endif</li>
        <li class="list-group-item text-right"><span class="pull-left"><i class="fa fa-birthday-cake"></i> <strong>Age:</strong></span>{{ $tutor->age or 'N/A' }}</li>
        <li class="list-group-item text-right"><span class="pull-left"><i class="fa fa-graduation-cap"></i> <strong>Grade:</strong></span> {{ $tutor->grade_name or 'N/A'}}</li>
        <li class="list-group-item text-right"><span class="pull-left"><i class="fa fa-money"></i> <strong>Rate:</strong></span> ${{ $tutor->rate or 'N/A'}}</li>
        <li class="list-group-item text-right"><span class="pull-left"><i class="fa fa-map-marker"></i> <strong>Location:</strong></span> {{ ucwords(strtolower($tutor->city)).', '.$tutor->state_prefix }}</li>
        <li class="list-group-item text-right"><span class="pull-left"><i class="fa fa-clock-o"></i> <strong>Listing Expiration:</strong></span> {{ isset($tutor->profile_expiration) ? date('m/d/y', strtotime($tutor->profile_expiration)) : 'N/A' }}</li>
        <li class="list-group-item text-right"><span class="pull-left"><i class="fa fa-sign-in"></i> <strong>Last Login:</strong></span> {{ isset($tutor->last_login) ? date('m/d/y', strtotime($tutor->last_login)) : 'N/A' }}</li>
        <li class="list-group-item text-right"><span class="pull-left"><i class="fa fa-exchange"></i> <strong>Joined:</strong></span> {{ date('m/d/y', strtotime($tutor->created_at)) }}</li>
      </ul>
    </div>
  </div>

  <div class="col-md-9">
    <div class="panel panel-default">
      <div class="panel-heading">Tutoring Subjects</div>
      <div class="panel-body">
        <ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" href="#Math">Math</a></li>
          <li><a data-toggle="tab" href="#Science">Science</a></li>
          <li><a data-toggle="tab" href="#SocialStudies">Social Studies</a></li>
          <li><a data-toggle="tab" href="#English">English</a></li>
          <li class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">Language <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a data-toggle="tab" href="#French">French</a></li>
                <li><a data-toggle="tab" href="#German">German</a></li>
                <li><a data-toggle="tab" href="#Italian">Italian</a></li>
                <li><a data-toggle="tab" href="#Mandarin">Mandarin</a></li>
                <li><a data-toggle="tab" href="#Spanish">Spanish</a></li>
            </ul>
        </li>
        <li><a data-toggle="tab" href="#Music">Music</a></li>
      </ul>

      <div class="tab-content">

@foreach($subjects as $subject)
<div id="{{ str_replace(' ', '', $subject) }}" class="tab-pane fade in @if($subject == 'Math') active @endif">
    <h3>{{ $subject }} Tutoring</h3>
    <br>
    <strong class="">Highest Completed {{ $subject }}:</strong> <span class="text-success">{{ $tutor->{'highest_'.strtolower(str_replace(' ', '', $subject))} or 'N/A' }}</span>
    <br>
    <br>
    <table class="table table-striped">
      <caption>I can tutor/teach the following:</caption>

      <tr>
        <th>Classes</th>
        <th>Highest Level I Can Tutor</th>
      </tr>

      @if(!empty($tutor->tutor_classes[$subject]))
      @foreach($tutor->tutor_classes[$subject] as $tutor_class)
      <tr>
        <td>{{ $tutor_class->class_name }}</td>
        <td>{{ $tutor_class->level_name }}</td>
      </tr>
      @endforeach
      @endif

    </table>
</div>
@endforeach

        </div>
      </div>
    </div>
  </div>
</div>

  <div class="row">
    <div class="col-md-12">
      <div class="well">
        <h2>Tutor Reviews <small>They now work!</small></h2>
        <span style="font-size: 24px" class="text-nowrap">
          {!! print_stars($tutor->reviews()->avg('rating')) !!}
          (<span class="text-primary">{{ $tutor->reviews()->count() }}</span>)
        </span>

@if($tutor->reviews()->get()->count() > 0)
        <p class="text-muted">{{ round($tutor->reviews()->avg('rating'), 1) }} out of 5 stars</p>
@else
        <p class="text-muted">No Reviews</p>
@endif
        <div class="text-left">
          <a href="#reviews-anchor" id="open-review-box" class="btn btn-success">Leave a Review</a>
        </div>

          <div class="row" id="post-review-box" style="display:none;">
            <div class="col-md-12">
              <hr style="height:1px;border:none;color:#333;background-color:#333;">
              <form accept-charset="UTF-8" action="" method="post">
                <div class="row">
						      <div class="col-md-5 form-group">
						        <label for="review_title">Review Title</label>
						        <input type="text" class="form-control" id="review_title" name="review_title" maxlength="100" placeholder="100 characters max" required>
						      </div>
						    </div>

						    <div class="row">
						      <div class="col-md-12">
                    <label>Who are you?</label>

                    <br>
                    <label class="radio-inline"><input type="radio" id="reviewer-type" name="reviewer" value="student" checked>Student</label>
                    <label class="radio-inline"><input type="radio" id="reviewer-type" name="reviewer" value="parent">Parent</label>

                    <div class="checkbox">
                    <label>
                    	<input type="checkbox" name="anonymous" value="1"> Make review anonymous
                    </label>
                    </div>

                    <div class="text-left text-nowrap">
                      <div class="stars starrr" data-rating="0"></div>
                    </div>

                    <input id="ratings-hidden" name="rating" type="hidden">

                    <textarea class="form-control animated" cols="50" id="new-review" name="message" maxlength="5000" placeholder="Enter your review here..." rows="5"></textarea>
                    <br>

                    <div class="text-right">
                      <a class="btn btn-danger btn-sm" href="#" id="close-review-box" style="display:none; margin-right: 10px;"><span class="glyphicon glyphicon-remove"></span> Cancel</a>
                      <button class="btn btn-success btn-lg" type="submit">Save</button>
                    </div>
						      </div>
						    </div>
              </form>
            </div>
          </div>
          <hr style="height:1px;border:none;color:#333;background-color:#333;">

@foreach($tutor->reviews()->join('users', 'users.id', '=', 'reviews.tutor_id')->get() as $review)
          <div class="row">
            <div class="col-md-12">
              <span style="font-size: 20px" class="text-nowrap">
                {!! print_stars($review->rating) !!}
              </span>

              <strong>{{ $review->title }}</strong>

              @if($review->anonymous != 1)
              <p class="text-muted">By <span class="text-primary">{{ $review->fname.' '.$review->lname }} ({{ $review->reviewer }})</span> on {{ date("M d, Y", strtotime($review->created_at)) }}
              @else
              <p class="text-muted">By <span class="text-primary"> a {{ $review->reviewer }}</span> on {{ date("M d, Y", strtotime($review->created_at)) }}
              @endif

              <p class="review">{!! nl2br($review->message) !!}</p>
            </div>
          </div>
          <hr>
@endforeach

@if(!empty($tutor->all_reviews))
{!! $tutor->all_reviews->render() !!}
@endif
        </div>
      </div>
    </div>
@include('/search/contactmodal')
