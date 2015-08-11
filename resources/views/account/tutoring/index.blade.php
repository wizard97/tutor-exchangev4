@extends('app')

@section('content')
<div class="container-fluid">
      <div class="row">
        @include('/account/tutoring/sidebar')
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

          <h1 class="page-header">Tutoring Dashboard</h1>
          @include('templates/feedback')

<div class="row">
  <div class="col-lg-7">

    <div class="panel panel-primary">
      <div class="panel-heading">
          <i class="fa fa-link fa-fw"></i> Quick Links
      </div>

      <div class="panel-body">
  <div class="btn-group btn-group-justified">

  <a class="btn btn-primary" href="{{ route('tutoring.info') }}">
    <i class="fa fa-info fa-2x"></i><br>
    Update Info
  </a>

  <a class="btn btn-primary" href="{{ route('tutoring.classes') }}">
    <i class="fa fa-graduation-cap fa-2x"></i><br>
    Update Classes
  </a>

  <a class="btn btn-primary" href="">
    <i class="fa fa-music fa-2x"></i><br>
    Update Music
  </a>

  <a class="btn btn-primary" href="">
    <i class="fa fa-calendar fa-2x"></i><br>
    Update Schedule
  </a>

  <a class="btn btn-primary" href="{{ route('tutoring.myprofile') }}">
    <i class="fa fa-user fa-2x"></i><br>
    View Profile
  </a>

  </div>
  </div>
</div>


<div class="row">
  <div class="col-md-7">
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-list fa-fw"></i> Tutoring Checklist
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
            <div class="list-group">
                <a href="{{ route('tutoring.info') }}" class="list-group-item">
                    <i class="fa fa-info fa-fw"></i> Your Info
                    <span class="pull-right">
                      @if($checklist['info']) <i class="fa fa-check" style="color:green; font-size:20px" data-toggle="tooltip" data-placement="right" title="Complete!"></i>
                      @else <i class="fa fa-exclamation-triangle" style="color:orange; font-size:20px" data-toggle="tooltip" data-placement="right" title="Incomplete!"></i>
                      @endif
                    </span>
                </a>
                <a href="{{ route('tutoring.classes') }}" class="list-group-item">
                    <i class="fa fa-graduation-cap fa-fw"></i> Your Classes
                    <span class="pull-right">
                      @if($checklist['classes']) <i class="fa fa-check" style="color:green; font-size:20px" data-toggle="tooltip" data-placement="right" title="Complete!"></i>
                      @else <i class="fa fa-exclamation-triangle" style="color:orange; font-size:20px" data-toggle="tooltip" data-placement="right" title="Incomplete!"></i>
                      @endif
                    </span>
                </a>
                <a href="#" class="list-group-item disabled">
                    <i class="fa fa-music fa-fw"></i> Your Music
                    <span class="pull-right">

                    </span>
                </a>
                <a href="#" class="list-group-item disabled">
                    <i class="fa fa-calendar fa-fw"></i> Your Schedule
                  <span class="pull-right">

                  </span>
                </a>

                <a href="#" class="list-group-item list-group-item-info">
                    <i class="fa fa-bolt fa-fw"></i> Listing Active
                    <span class="pull-right">
                      @if($checklist['active']) <i class="fa fa-check" style="color:green; font-size:20px" data-toggle="tooltip" data-placement="right" title="Yes!"></i>
                      @else <i class="fa fa-exclamation-triangle" style="color:orange; font-size:20px" data-toggle="tooltip" data-placement="right" title="No!"></i>
                      @endif
                    </span>
                </a>

            </div>

            <!-- /.list-group -->
            @if(!$tutor->tutor_active)
            <a href="{{ route('tutoring.runlisting')}}" class="btn btn-success btn-block"><i class="fa fa-play"></i> Renew Tutoring</a>
            @else
            <a href="{{ route('tutoring.pauselisting')}}" class="btn btn-warning btn-block"><i class="fa fa-pause"></i> Pause Tutoring</a>
            @endif
        </div>
        <!-- /.panel-body -->
    </div>
  </div>

  <div class="col-md-5">
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-camera fa-fw"></i> Profile Picture
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
          <img src="{{ route('profileimage.showfull', ['id' => Auth::user()->id]) }}" class="img-responsive img-rounded" alt="Profle Picture">
          <br>
          <button class="btn btn-info btn-block" data-toggle="modal" data-target="#image"><i class="fa fa-upload"></i> Upload Picutre</button>
          @if(Auth::user()->has_picture)<a href="{{ route('profileimage.destroy') }}" class="btn btn-danger btn-block"><i class="fa fa-trash"></i> Delete Picture</a>@endif
        </div>
        <!-- /.panel-body -->
    </div>
  </div>
</div>


  <div class="panel panel-default">
      <div class="panel-heading">
          <i class="fa fa-line-chart fa-fw"></i> Your Popularity
      </div>

      <div class="panel-body">
        <h3 style="text-align: center; margin-bottom: 0px;">Total Tutoring Inquiries</h3>
        <div id="myfirstchart"></div>

      </div>
  </div>



</div>

<div class="col-lg-5">
  <div class="well well">
    <h3>Welcome {{ Auth::user()->fname }},</h3>
    <p>This is your tutoring dashboard, use it to help manage your tutoring.</p>
  </div>

  <div class="panel panel-danger">
      <div class="panel-heading">
          <i class="fa fa-bell fa-fw"></i> Notifications
      </div>
      <!-- /.panel-heading -->
      <div class="panel-body">
        @if($tutor->tutor_active && strtotime($tutor->profile_expiration) > time())
        <p class="alert alert-success"><i class="fa fa-info-circle"></i> Your listing is currently active!</p>
        @else
        <p class="alert alert-danger"><i class="fa fa-info-circle"></i> Your listing is not currently active!</p>
        @endif
        @if(strtotime($tutor->profile_expiration) < strtotime('1 week') && $tutor->tutor_active)
        <p class="alert alert-warning"><i class="fa fa-info-circle"></i> Your listing expires in less than a week!</p>
        @endif
        <p class="text text-muted bg-warning"><span class="text text-danger">Attention:</br></span>we now have an updated <a href="/LextutorexchangePrivacyPolicy.pdf" target="_blank">Privacy Policy</a> and <a href="/LextutorexchangeTermsofUse.pdf" target="_blank">Terms of Use</a>. We advise that you read these documents, as your use of this websites constitutes your agreement to these terms. Thank you, </br>The Creators</p>
      </div>
      <!-- /.panel-body -->
  </div>

  <div class="panel panel-default">
      <div class="panel-heading">
          <i class="fa fa-user fa-fw"></i> Tutoring Stats
      </div>
      <div class="panel-body">
      <br>
      <ul class="list-group">
          <?php $expiration = new DateTime($tutor->profile_expiration); $now = new DateTime(date("Y-m-d H:i:s")); $interval = $expiration->diff($now); ?>
          <li class="list-group-item"><i class="fa fa-clock-o fa-fw"></i> Listing Expiration:<span class="pull-right text-muted">{{ $interval->days }} days ( @if(!empty($tutor->profile_expiration)){{ date('m/d/Y', strtotime($tutor->profile_expiration)) }}@else N/A @endif)</span></li>
          <li class="list-group-item"><i class="fa fa-eye fa-fw"></i> Profile Views:<span class="pull-right text-muted">{{ $tutor->profile_views }} view(s)</span></li>
          <li class="list-group-item"><i class="fa fa-envelope fa-fw"></i> Contacted:<span class="pull-right text-muted">{{ $contacts->count() }} time(s)</span></li>
      </ul>
  </div>
  </div>

</div>

<div class="col-md-7">

  <div class="panel panel-default">
      <div class="panel-heading">
          <i class="fa fa-comments fa-fw"></i> Tutoring Inquiries
      </div>
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-striped site-datatable">
            <thead>
              <tr>
                <th>From</th>
                <th>Subject</th>
                <th>Message</th>
                <th>Date</th>
              </tr>
            </thead>
            <tbody>
              @foreach($contacts as $contact)
              <tr>
                <td>{{ $contact->fname.' '.$contact->lname }}</td>
                <td>{{ $contact->subject }}</td>
                <td> <div class="contact-message">{!! nl2br($contact->message) !!}</div></td>
                <td>{{ date ("m/d/Y", strtotime($contact->created_at)) }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>

      </div>
  </div>
</div>


</div>


        </div>
      </div>


      <!-- Modal -->
      <div class="modal fade" id="image" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            {!! Form::open(['url' => route('profileimage.store'), 'files' => true]) !!}
            {!! csrf_field() !!}
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Upload Profile Picture</h4>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label>Image</label>
                {!! Form::file('image') !!}
                <p class="help-block">Only registered user's will be able to view your profile image.</p>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times-circle fa-fw"></i> Cancel</button>
              <button type="submit" class="btn btn-success"><i class="fa fa-upload fa-fw"></i> Upload</button>
            </div>
            {!! Form::close() !!}
          </div>
        </div>
      </div>

    </div>

    <script>
    $( document ).ready(function() {
        $('.contact-message').readmore({
          collapsedHeight: 100,
          moreLink: '<a href="#">Expand »</a>',
          lessLink: '<a href="#">Close</a>',
        });
    });

    $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

    new Morris.Line({
      yLabelFormat: function(y){return y != Math.round(y)?'':y;},
  // ID of the element in which to draw the chart.
  element: 'myfirstchart',
  // Chart data records -- each entry in this array corresponds to a point on
  // the chart.
  data: {!! json_encode($contacts_array) !!},
  dateFormat: function (x) {
     return new Date(x).toLocaleString();
   },

  // The name of the data record attribute that contains x-values.
  xkey: 'date',
  // A list of names of data record attributes that contain y-values.
  ykeys: ['total_contacts'],
  // Labels for the ykeys -- will be displayed when you hover over the
  // chart.
  labels: ['Total Tutoring Inquiries'],


  resize: true,
  parseTime: true,
  hideHover: true
});
    </script>
    @stop
