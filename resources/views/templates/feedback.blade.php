<?php
//pull out all the session stuff first
$fp = \Session::pull('feedback_positive');
$fw = \Session::pull('feedback_warning');
$fn = \Session::pull('feedback_negative');

\Request::session()->forget('feedback_positive');
\Request::session()->forget('feedback_warning');
\Request::session()->forget('feedback_negative');
?>
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

@if(!empty($fp))
<div class="alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <h4><i class="fa fa-thumbs-up"></i> Nice Work! </h4>{!! $fp !!}</div>
@endif

@if(!empty($fw))
<div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <h4><i class="fa fa-info-circle"></i> Watch out! </h4>{!! $fw !!}</div>
@endif

@if(!empty($fn))
<div class="alert alert-danger alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <h4><i class="fa fa-info-circle"></i> Watch out! </h4>{!! $fn !!}</div>
@endif
</div>
<?php
unset($errors);
 ?>
