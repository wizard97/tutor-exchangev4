<?php
namespace App\Repositories\Messenger\Thread;

use App\Repositories\BaseRepository;

use App\Models\Messenger\Thread;
use App\Repositories\Participant\ParticipantRepository;
use DB;
use Debugbar;

class ThreadRepository extends BaseRepository implements ThreadRepositoryContract
{

  public function __construct(Thread $model)
  {
    $this->model = $model;
  }


  /**
   * Returns all of the latest threads by updated_at date.
   *
   * @return created model
   */
  public function create($input, $user_id)
  {
      $thread = new $this->model;
      $thread->subject = $input['subject'];
      // Record creator
      $thread->user_id = $user_id;
      $thread->save();
      // Add user
      if (!is_null($user_id))
      {
        $thread->addParticipants([$user_id]);
      }
      return $thread;
  }


  /**
   * Returns all of the latest threads by updated_at date.
   *
   * @return mixed
   */
  public function getAllLatest()
  {
      return $this->model->latest('updated_at')->get();
  }

  /**
   * Returns all of the users private threads
   *
   * @return mixed
   */
  public function getAllUsersRecvPrivate($user_id)
  {
      return $this->model
        ->join('participants', 'participants.thread_id', '=', 'threads.id')
        ->where('private', true)
        ->where('participants.user_id', $user_id)
        ->where('threads.user_id', '!=', $user_id)
        ->latest('threads.created_at')
        ->get();
  }

  /**
   * Returns all the ids of users in private threads started by this user
   *
   * @return array
   */
  public function getUsersPrivateSentIds($user_id)
  {
      return $this->model
        ->join('participants', 'participants.thread_id', '=', 'threads.id')
        ->where('private', true)
        // Started by user
        ->where('threads.user_id', $user_id)
        ->where('participants.user_id', '!=', $user_id)
        ->groupBy('participants.user_id')
        ->select('participants.user_id')
        ->get()
        ->pluck('user_id')
        ->toArray();
  }

  /**
   * Returns total site ontacts
   *
   * @return array
   */
  public function countTutorContacts()
  {
      return $this->model
          ->join('participants', function ($join) {
              $join->on('participants.thread_id', '=', 'threads.id');
                // Ignore the user who starterd the thread;
                $join->on('participants.user_id', '!=', 'threads.user_id');
            })
            // Maker sure one of recievers is a tutor

        ->join('users', 'participants.user_id', '=', 'users.id')
        ->where('private', true)
        ->where('users.account_type', '>', 1)
        ->distinct('threads.id')
        ->count();

  }


  public function getRecipients($thread_id, $user_id)
  {
    $recipients = $this->model
    ->findOrFail($thread_id)
    ->participants()//->get()
    ->join('users', 'user_id', '=', 'users.id')
    ->where('user_id', '!=', $user_id)
    ->select('participants.*', 'users.id as user_id', DB::raw("CONCAT(users.fname,' ',users.lname) AS full_name"), 'users.account_type as account_type')
    ->get();
    return $recipients;
  }
}
