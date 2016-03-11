@extends('app')

@section('content')

<style>
.nav-tabs .glyphicon:not(.no-margin) { margin-right:10px; }
.tab-pane .list-group-item:first-child {border-top-right-radius: 0px;border-top-left-radius: 0px;}
.tab-pane .list-group-item:last-child {border-bottom-right-radius: 0px;border-bottom-left-radius: 0px;}
.tab-pane .list-group .checkbox { display: inline-block;margin: 0px; }
.tab-pane .list-group input[type="checkbox"]{ margin-top: 2px; }
.tab-pane .list-group .glyphicon { margin-right:5px; }
.tab-pane .list-group .glyphicon:hover { color:#FFBC00; }
a.list-group-item.read { color: #222;background-color: #F3F3F3; }
hr { margin-top: 5px;margin-bottom: 10px; }
.nav-pills>li>a {padding: 5px 10px;}

.ad { padding: 5px;background: #F5F5F5;color: #222;font-size: 80%;border: 1px solid #E5E5E5; }
.ad a.title {color: #15C;text-decoration: none;font-weight: bold;font-size: 110%;}
.ad a.url {color: #093;text-decoration: none;}
</style>

<div class="container">
  @include('templates/feedback')
  <div class="page-header">
    <h1>Messages</h1>
  </div>
    <div class="row">
        <div class="col-sm-3 col-md-2">
            <div class="btn-group">
              <a href="{{ route('myaccount.dashboard') }}"type="button" class="btn btn-primary"><i class="fa fa-home fa-fw"></i> Dashboard</a>
              <!--
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                    Mail <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Mail</a></li>
                    <li><a href="#">Contacts</a></li>
                    <li><a href="#">Tasks</a></li>
                </ul>
              -->
            </div>
        </div>
        <div class="col-sm-9 col-md-10">
            <!-- Split button -->
            <!--
            <div class="btn-group">
                <button type="button" class="btn btn-default">
                    <div class="checkbox" style="margin: 0;">
                        <label>
                            <input type="checkbox">
                        </label>
                    </div>
                </button>
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span><span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="#">All</a></li>
                    <li><a href="#">None</a></li>
                    <li><a href="#">Read</a></li>
                    <li><a href="#">Unread</a></li>
                    <li><a href="#">Starred</a></li>
                    <li><a href="#">Unstarred</a></li>
                </ul>
            </div>
          -->
            <button id="refresh-btn" type="button" class="btn btn-default" data-toggle="tooltip" title="Refresh">
                   <span class="glyphicon glyphicon-refresh"></span>   </button>
            <!-- Single button -->
            <!--
            <div class="btn-group">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    More <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Mark all as read</a></li>
                    <li class="divider"></li>
                    <li class="text-center"><small class="text-muted">Select messages to see more actions</small></li>
                </ul>
            </div>
          -->
            <div class="pull-right">
                <span class="text-muted">
                  @if($messages->count() > 0)
                    <b>{{ $messages->firstItem() }}</b>–<b>{{ $messages->lastItem() }}</b> of <b>{{ $messages->total() }}</b>
                  @else
                    <b>0 of 0</b>
                  @endif
                </span>

            </div>
        </div>
    </div>
    <hr />
    <div class="row">
        <div class="col-sm-3 col-md-2">
            <a href="{{ route('messages.create') }}" class="btn btn-danger btn-sm btn-block" role="button">COMPOSE</a>
            <hr />
            <ul class="nav nav-pills nav-stacked">
                <li class="{{ isActiveRoute('messages.index') }}"><a href="{{route('messages.index')}}"><span class="badge pull-right">{{ $unread }}</span> Inbox </a>
                </li>
                <li class="{{ isActiveRoute('messages.sent') }}"><a href="{{route('messages.sent')}}">Sent Mail</a></li>
            </ul>
        </div>
        <div class="col-sm-9 col-md-10">
            <!-- Nav tabs -->

            <ul class="nav nav-tabs">
                <li class="active"><a href="#home" data-toggle="tab"><span class="glyphicon glyphicon-inbox">
                </span>Inbox</a></li>
                <!--
                <li><a href="#profile" data-toggle="tab"><span class="glyphicon glyphicon-user"></span>
                    Social</a></li>
                <li><a href="#messages" data-toggle="tab"><span class="glyphicon glyphicon-tags"></span>
                    Promotions</a></li>
                <li><a href="#settings" data-toggle="tab"><span class="glyphicon glyphicon-plus no-margin">
                </span></a></li>
              -->
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane fade in active" id="home">
                    <div class="list-group">
                      @if($messages->count() > 0)
                          @foreach($messages as $m)
                          <?php $class = $m->isUnread($currentUserId) ? '' : 'read'; ?>

                          <a href="{{ route('messages.show', ['id' => $m->thread->id]) }}" class="list-group-item {{ $class }}">
                              @if($m->hasReply($currentUserId))
                              <i class="fa fa-reply fa-fw" data-toggle="tooltip" title="Replied"></i>
                              @else
                              <i class="fa fa-reply fa-fw" style="visibility: hidden;"></i>
                              @endif
                              <span class="name" style="min-width: 120px; display: inline-block">{!! $m->user->getName()!!}</span>
                              <span class="">
                                @if($m->isReplyForUser($currentUserId))
                                Re:
                                @endif
                                {{ $m->thread->subject }}
                              </span>
                              <span class="text-muted" style="font-size: 12px;">
                                - {!! substr(strip_tags($m->body), 0, 30) !!}...
                              </span>
                              @if ($m->updated_at->isToday())
                              <span class="badge">{{ $m->updated_at->format('h:i A') }}</span>
                              @else
                              <span class="badge">{{ $m->updated_at->toFormattedDateString()  }}</span>
                              @endif
                                <span class="pull-right">
                                  <!-- <span class="glyphicon glyphicon-paperclip"></span> -->
                                </span>
                            </a>
                          @endforeach
                      @else
                      <br>
                      <div class="alert alert-info" role="alert">
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                          Sorry, you have no messages.
                      </div>
                      @endif
                    </div>
                </div>
                @if($messages->count() > 0)
                  {!! $messages->links() !!}
                @endif
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
    // Refresh button
    $('#refresh-btn').click(function() {
        location.reload();
    });
});
</script>
@stop
