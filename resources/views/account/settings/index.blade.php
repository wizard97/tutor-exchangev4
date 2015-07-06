<!-- resources/views/auth/register.blade.php -->
@extends('app')

@section('content')
<div class="container">
<div class="page-header">
  <h1>Account Settings</h1>
</div>

@include('templates/feedback')
  <div class="col-md-6">
    <ul class="list-group">

      <li  class="list-group-item">
        <div class="row">
          <div class="col-xs-8">
            <h4 class="list-group-item-heading">Name:</h4>
            <p class="list-group-item-text text-muted">
              {{ Auth::user()->fname.' '.Auth::user()->lname }}
            </p>
          </div>
          <div class="col-xs-4">
            <button class="btn btn-warning pull-right" data-toggle="modal" data-target="#name"><i class="fa fa-pencil"></i> Edit</button>
          </div>
        </div>
      </li>

      <li  class="list-group-item">
        <div class="row">
          <div class="col-xs-8">
            <h4 class="list-group-item-heading">Email:</h4>
            <p class="list-group-item-text text-muted">
              {{ Auth::user()->email }}
            </p>
          </div>
          <div class="col-xs-4">
            <button class="btn btn-warning pull-right" data-toggle="modal" data-target="#email"><i class="fa fa-pencil"></i> Edit</button>
          </div>
        </div>
      </li>

      <li  class="list-group-item">
        <div class="row">
          <div class="col-xs-8">
            <h4 class="list-group-item-heading">Zip Code:</h4>
            <p class="list-group-item-text text-muted">
              {{ Auth::user()->zip }}
            </p>
          </div>
          <div class="col-xs-4">
            <button class="btn btn-warning pull-right" data-toggle="modal" data-target="#zip"><i class="fa fa-pencil"></i> Edit</button>
          </div>
        </div>
      </li>

      <li  class="list-group-item">
        <div class="row">
          <div class="col-xs-8">
            <h4 class="list-group-item-heading">Account Type:</h4>
            <p class="list-group-item-text text-muted">
              @if(Auth::user()->account_type == 3) Professional Tutor
              @elseif(Auth::user()->account_type == 2) Standard Tutor
              @else Standard (looking for a tutor)
              @endif
            </p>
          </div>
          <div class="col-xs-4">
            <button class="btn btn-warning pull-right" data-toggle="modal" data-target="#account_type"><i class="fa fa-pencil"></i> Edit</button>
          </div>
        </div>
      </li>

      <li  class="list-group-item">
        <div class="row">
          <div class="col-xs-8">
            <h4 class="list-group-item-heading">Password:</h4>
            <p class="list-group-item-text text-muted">
              **********
            </p>
          </div>
          <div class="col-xs-4">
            <button class="btn btn-warning pull-right" data-toggle="modal" data-target="#password"><i class="fa fa-pencil"></i> Edit</button>
          </div>
        </div>
      </li>

    </ul>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="name" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        {!! Form::open(['url' => route('editName')]) !!}
        {!! csrf_field() !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Edit My Name</h4>
        </div>
        <div class="modal-body">

          <div class="form-group">
            {!! Form::label('fname', 'New first name') !!}
            {!! Form::text('fname', null, ['class' => 'form-control']) !!}
          </div>

          <div class="form-group">
            {!! Form::label('lname', 'New last name') !!}
            {!! Form::text('lname', null, ['class' => 'form-control']) !!}
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times-circle fa-fw"></i> Cancel</button>
          <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o fa-fw"></i> Update</button>
        </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="email" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        {!! Form::open(['url' => route('editEmail')]) !!}
        {!! csrf_field() !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Edit My Email</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            {!! Form::label('email', 'New email') !!}
            {!! Form::email('email', null, ['class' => 'form-control']) !!}
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times-circle fa-fw"></i> Cancel</button>
          <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o fa-fw"></i> Update</button>
        </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="zip" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        {!! Form::open(['url' => route('editZip')]) !!}
        {!! csrf_field() !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Edit My Zip Code</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            {!! Form::label('zip', 'New Zip code') !!}
            {!! Form::text('zip', null, ['class' => 'form-control']) !!}
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times-circle fa-fw"></i> Cancel</button>
          <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o fa-fw"></i> Update</button>
        </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="account_type" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        {!! Form::open(['url' => route('editAccountType')]) !!}
        {!! csrf_field() !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Change My Account Type</h4>
        </div>
        <div class="modal-body">
          <label>New account type</label>
          <br>
          <div class="btn-group" data-toggle="buttons">
            <label class="btn btn-primary">
              {!! Form::radio('account_type', '1') !!} Standard
            </label>
            <label class="btn btn-primary">
              {!! Form::radio('account_type', '2') !!} Standard Tutor
            </label>
            <label class="btn btn-primary">
              {!! Form::radio('account_type', '3') !!} Professional Tutor
            </label>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times-circle fa-fw"></i> Cancel</button>
          <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o fa-fw"></i> Update</button>
        </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="password" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        {!! Form::open(['url' => route('editPassword')]) !!}
        {!! csrf_field() !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Change My Password</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            {!! Form::label('password', 'New password') !!}
            {!! Form::password('password', ['class' => 'form-control']) !!}
          <p class="help-block">Minimum 6 characters</p>
          </div>


          <div class="form-group">
            {!! Form::label('password_confirmation', 'Repeat Password') !!}
            {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times-circle fa-fw"></i> Cancel</button>
          <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o fa-fw"></i> Update</button>
        </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>


</div>
@stop
