
<div id="feedback">
@if (count($errors) > 0)
<!-- Also can be printed out with javascript-->
<div class="alert alert-danger">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <h4><i class="fa fa-info-circle"></i> Watch out! </h4>
<ul>
    @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
    @endforeach
</ul>
</div>
@endif

@if(Session::has('feedback_positive'))
<div class="alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <h4><i class="fa fa-thumbs-up"></i> Nice Work! </h4>{{ Session::get('feedback_positive') }}</div>
@endif

@if(Session::has('feedback_negative'))
<div class="alert alert-danger alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <h4><i class="fa fa-info-circle"></i> Watch out! </h4>{{ Session::get('feedback_negative') }}</div>
@endif
</div>

<?php
\Request::session()->forget('feedback_positive');
\Request::session()->forget('feedback_negative');
unset($errors);
?>
