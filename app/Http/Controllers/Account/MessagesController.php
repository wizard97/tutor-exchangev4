<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\User\User;
use Carbon\Carbon;

// Remove later
use App\Models\Messenger\Message;
use App\Models\Messenger\Participant;
use App\Models\Messenger\Thread;

use App\Repositories\User\UserRepository;
use App\Repositories\Tutor\TutorRepository;
use App\Repositories\Messenger\Thread\ThreadRepository;
use App\Repositories\Messenger\Message\MessageRepository;
use App\Repositories\Messenger\Participant\ParticipantRepository;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Mail;

use App\Http\Controllers\Controller;
use Debugbar;

class MessagesController extends Controller
{

  public function __construct(UserRepository $userRepository)
  {
    $this->userRepository = $userRepository;
  }

  /**
  * Show all of the message the user sent
  *
  * @return mixed
  */
  public function viewSent(MessageRepository $messageRepository)
  {
    $currentUserId = Auth::user()->id;

    $messages = $messageRepository->getAllUsersSentLatest($currentUserId, 15);
    $unread =$messageRepository->countUsersUnread($currentUserId);


    return view('account.messenger.index', compact('messages', 'currentUserId', 'unread'));
  }


  /**
  * Show all of the message threads to the user.
  *
  * @return mixed
  */
  public function index(MessageRepository $messageRepository)
  {
    $currentUserId = Auth::user()->id;

    $messages = $messageRepository->getAllUsersLatest($currentUserId, 15);
    $unread =$messageRepository->countUsersUnread($currentUserId);


    return view('account.messenger.index', compact('messages', 'currentUserId', 'unread'));
  }

  /**
  * Shows a message thread.
  *
  * @param $id
  * @return mixed
  */
  public function show(ThreadRepository $threadRepository, $id)
  {
    $userId = Auth::user()->id;
    try {
      //Make sure user has permission
      $thread =$threadRepository->getById($id);
      if (!$thread->hasParticipant($userId)) throw new ModelNotFoundException;

    } catch (ModelNotFoundException $e) {
      Session::flash('error_message', 'The thread with ID: ' . $id . ' was not found.');

      return redirect(route('messages.index'));
    }

    // show current user in list if not a current participant
    // $users = User::whereNotIn('id', $thread->participantsUserIds())->get();

    // don't show the current user in list

    $thread->markAsRead($userId);
    $recipients = $threadRepository
    ->getRecipients($id, $userId);
    return view('account.messenger.show', compact('thread', 'userId', 'recipients'));
  }

  /**
  * Creates a new message thread.
  *
  * @return mixed
  */
  public function create()
  {
    $users = User::where('id', '!=', Auth::id())->get();

    return view('account.messenger.create', compact('users'));
  }

  /**
  * Stores a new message thread.
  *
  * @return mixed
  */
  public function store(ThreadRepository $threadRepository, MessageRepository $messageRepository,
  Request $request)
  {
    $this->validate($request, [
      'subject' => 'required|string',
      'message' => 'required|string',
      'recipients' => 'required|array|not_in:'.\Auth::id()
    ]);

    $userId = Auth::id();
    $input = $request->all();
    //Create the new thread
    $thread = $threadRepository->create($input, $userId);

    $messageModel = $messageRepository->create($input, $thread, $userId);
    // Recipients
    if ($request->has('recipients')) {
      $thread->addParticipants($request->input('recipients')); // FIX
    }

    $this->sendNewMessageEmail($messageModel);

    \Session::put('feedback_positive', 'Your message has been successfully sent!');
    return redirect(route('messages.index'));
  }

  /**
  * Store method through ajax
  */
  public function storeAjax(ThreadRepository $threadRepository, MessageRepository $messageRepository,
  TutorRepository $tutorRepository, Request $request)
  {
    $userId = \Auth::id();
    $this->validate($request, [
      'user_id' => 'required|exists:tutors,user_id|not_in:'.$userId,
      'subject' => 'required|string',
      'message' => 'required|string',
    ]);

    $tutor = $tutorRepository->getById($request->get('user_id'));

    $input = $request->all();
    //Create the new thread
    $thread = $threadRepository->create($input, $userId);
    // Add Tutor
    $thread->addParticipants([$tutor->user_id]);
    // Create the message
    $messageModel = $messageRepository->create($input, $thread, $userId);
    //Send notification email
    $this->sendNewMessageEmail($messageModel);

    \Session::put('feedback_positive', 'Your email to '.$tutor->fname.' '.$tutor->lname.' has been successfully sent!');

    return view('templates/feedback');

  }



  /**
  * Adds a new message to a current thread.
  *
  * @param $id
  * @return mixed
  */
  public function update(ThreadRepository $threadRepository,
  MessageRepository $messageRepository, Request $request, $id)
  {
    $userId = Auth::id();
    try {
      $thread = $threadRepository->getById($id);
      if (!$thread->hasParticipant($userId)) throw new ModelNotFoundException;
    } catch (ModelNotFoundException $e) {
      Session::flash('feedback_negative', 'The thread with ID: ' . $id . ' was not found.');

      return redirect(route('messages.index'));
    }

    $thread->activateAllParticipants();

    $messageModel = $messageRepository->create($request->all(), $thread, $userId);


    // Add replier as a participant
    $participant = $thread->participants()->firstOrCreate(
    [
      'thread_id' => $thread->id,
      'user_id'   => $userId,
    ]);
    $participant->last_read = new Carbon;
    $participant->save();

    // Recipients
    if ($request->has('recipients')) {
      $thread->addParticipants($request->get('recipients'));
    }

    $this->sendNewMessageEmail($messageModel);

    return redirect('account/messages/' . $id);
  }

  /*
  * Sends user email with new message
  */
  protected function sendNewMessageEmail($messageModel)
  {
    //var_dump($message->user());
    $user = $messageModel->user;
    $from = $user->getName();

    foreach ($messageModel->getRecipientParticipants() as $participant)
    {
      $to = $participant->user;

      Mail::queue('emails.messaging.recievedmessage', compact('messageModel', 'user', 'to'), function ($m) use ($to, $from) {
        $m->from('noreply@lextutorexchange.com', 'Lexington Tutor Exchange');
        $m->to($to->email, $to->getName());
        $m->subject("New Message From {$from}");
      });
    }
  }


  public function recipientquery(UserRepository $userRepository, $query)
  {

    $matches = $userRepository
    ->possibleRecipientsQuery($query, \Auth::id());
    //Debugbar::info($matches);
    return $matches->toJson();
  }


  public function recipientprefetch(UserRepository $userRepository)
  {
    $prefetch = $userRepository->possibleRecipientsPrefetch(\Auth::id());
    //Debugbar::info($prefetch);
    return $prefetch->toJson();
  }
}
