@extends('app')

@section('content')
<div class="container-fluid">
      <div class="row">
        @include('/account/tutoring/sidebar')
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

          @include('templates/feedback')

          <h1 class="page-header">Tutoring Dashboard</h1>

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
                <a href="#" class="list-group-item">
                    <i class="fa fa-info fa-fw"></i> Your Info
                    <span class="pull-right"><i class="fa fa-check" style="color:green; font-size:20px"></i>
                    </span>
                </a>
                <a href="#" class="list-group-item">
                    <i class="fa fa-graduation-cap fa-fw"></i> Your Classes
                    <span class="pull-right"><i class="fa fa-exclamation-triangle" style="color:orange; font-size:20px"></i>
                    </span>
                </a>
                <a href="#" class="list-group-item">
                    <i class="fa fa-music fa-fw"></i> Your Music
                    <span class="pull-right"><i class="fa fa-check" style="color:green; font-size:20px"></i>
                    </span>
                </a>
                <a href="#" class="list-group-item">
                    <i class="fa fa-calendar fa-fw"></i> Your Schedule
                  <span class="pull-right"><i class="fa fa-check" style="color:green; font-size:20px"></i>
                    </span>
                </a>

                <a href="#" class="list-group-item list-group-item-info">
                    <i class="fa fa-bolt fa-fw"></i> Listing Active
                    <span class="pull-right"><i class="fa fa-check" style="color:green; font-size:20px"></i>
                    </span>
                </a>

            </div>

            <!-- /.list-group -->
            <a href="#" class="btn btn-success btn-block"><i class="fa fa-play"></i> Start Tutoring</a>
            <a href="#" class="btn btn-warning btn-block"><i class="fa fa-pause"></i> Pause Tutoring</a>
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
          <a href="{{ route('profileimage.destroy') }}" class="btn btn-danger btn-block"><i class="fa fa-trash"></i> Delete Picture</a>
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
        <div id="myfirstchart"></div>

      </div>
  </div>



</div>

<div class="col-lg-5">
  <div class="well well">
    <h3>Welcome {{ Auth::user()->fname }},</h3>
    <p>This is your tutoring dashboard, use it to help manage your tutoring.</p>
  </div>

  <div class="panel panel-default">
      <div class="panel-heading">
          <i class="fa fa-bell fa-fw"></i> Notices
      </div>
      <!-- /.panel-heading -->
      <div class="panel-body">
        <p class="alert alert-success"><i class="fa fa-info-circle"></i> Your listing is currently active!</p>
        <p class="alert alert-warning"><i class="fa fa-info-circle"></i> Your listing expires in less than a week!</p>
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
          <li class="list-group-item"><i class="fa fa-clock-o fa-fw"></i> Listing Expiration:<span class="pull-right text-muted"></span></li>
          <li class="list-group-item"><i class="fa fa-eye fa-fw"></i> Profile Views:<span class="pull-right text-muted"></span></li>
          <li class="list-group-item"><i class="fa fa-envelope fa-fw"></i> Contacted:<span class="pull-right text-muted"> time(s)</span></li>
      </ul>
  </div>
  </div>

</div>




</div>


          <h2 class="sub-header">Tutoring Inquiries</h2>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Contact id#</th>
                  <th>From</th>
                  <th>Subject</th>
                  <th>Message</th>
                  <th>Date</th>
                </tr>
              </thead>
              <tbody>
                <?php $contact_num = 0; ?>
                @foreach($contacts as $contact)
                <?php $contact_num++; ?>
                <tr>
                  <td>{{ $contact_num}}</td>
                  <td>{{ $contact->fname.' '.$contact->lname }}</td>
                  <td>{{ $contact->subject }}</td>
                  <td>{{ $contact->message }}</td>
                  <td>{{ $contact->created_at }}</td>
                  <td>sit</td>
                </tr>
                @endforeach
              </tbody>
            </table>
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
                <label>Image Input</label>
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
    new Morris.Area({
      yLabelFormat: function(y){return y != Math.round(y)?'':y;},
  // ID of the element in which to draw the chart.
  element: 'myfirstchart',
  // Chart data records -- each entry in this array corresponds to a point on
  // the chart.
  data: [
    { year: '2012-02-24', value: 0 },
    { year: '2012-05-16', value: 2 },
    { year: '2012-12-24', value: 5 },
    { year: '2013-03-5', value: 10 },
    { year: '2013-11-10', value: 27 }
  ],
  // The name of the data record attribute that contains x-values.
  xkey: 'year',
  // A list of names of data record attributes that contain y-values.
  ykeys: ['value'],
  // Labels for the ykeys -- will be displayed when you hover over the
  // chart.
  labels: ['Total Tutoring Inquiries'],


  resize: true,
  parseTime: true,
  hideHover: true
});
    </script>
    @stop
