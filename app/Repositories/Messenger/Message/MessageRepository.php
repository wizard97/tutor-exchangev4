<?php
namespace App\Repositories\Messenger\Message;

use App\Repositories\BaseRepository;

use App\Models\Messenger\Message;

class MessageRepository extends BaseRepository implements MessageRepositoryContract
{

  public function __construct(Message $model)
  {
    $this->model = $model;
  }

  /**
   * Returns all of the latest threads by updated_at date.
   *
   * @return mixed
   */
  public function getAllUsersLatest($user_id)
  {
      return $this->model->with('thread')->forUser($user_id)->get();
  }

}
