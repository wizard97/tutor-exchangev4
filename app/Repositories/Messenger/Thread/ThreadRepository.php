<?php
namespace App\Repositories\Messenger\Thread;

use App\Repositories\BaseRepository;

use App\Models\Messenger\Thread;
use App\Repositories\Participant\ParticipantRepository;

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
  public function create($input, $user_id = NULL)
  {
      $thread = new $this->model;
      $thread->subject = $input['subject'];
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
      return $this->model->latest('updated_at');
  }

}
