<div class="row">
  <div class="col-md-3">

    <div class="row">
      <img src="{{ $tutor->has_picture }}" width="300" height="300" class="img-thumbnail img-responsive center-block">
    </div>

  <div class="row">
    <div class="text-center">
      <button type="button" id="save_btn" name="saved_tutors_id[]" value="{{$tutor->user_id}}" class="btn btn-info" aria-expanded="false"><span class="glyphicon glyphicon-floppy-saved" aria-hidden="true"></span> Saved!</button>
      <button type="button" id="save_btn" name="saved_tutors_id[]" value="{{$tutor->user_id}}" class="btn btn-warning" aria-expanded="false"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Save me!</button>
      <a class="btn btn-primary" href="" role="button"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Contact Me</a>
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
        <li class="list-group-item text-right"><span class="pull-left"><i class="fa fa-map-marker"></i> <strong>Zip Code:</strong></span> {{ $tutor->zip or 'N/A'}}</li>
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
    <strong>Highest Completed {{ $subject }}: </strong>

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
@for($i = 0; $i < $tutor->star_count; $i++)<i style="color: #FEC601" class="fa fa-star"></i>@endfor
@if($tutor->half_star)<i style="color: #FEC601" class="fa fa-star-half-o"></i>@endif
@for($i = 0; $i < $tutor->empty_stars; $i++)<i style="color: #FEC601" class="fa fa-star-o"></i>@endfor
          (<span class="text-primary">{{ $tutor->num_reviews }}</span>)
        </span>

@if($tutor->num_reviews > 0)
        <p class="text-muted">{{ $tutor->rating }} out of 5 stars</p>
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

@foreach($tutor->all_reviews as $review)
          <div class="row">
            <div class="col-md-12">
              <span style="font-size: 20px" class="text-nowrap">
@for($i = 0; $i < $review->rating; $i++)<i style="color: #FEC601" class="fa fa-star"></i>@endfor
@for($i = 0; $i < 5 - $review->rating; $i++)<i style="color: #FEC601" class="fa fa-star-o"></i>@endfor
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

        </div>
      </div>
    </div>
