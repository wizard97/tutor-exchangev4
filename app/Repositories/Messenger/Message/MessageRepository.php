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

  public function create()
  {

  }

  public function findBySearch()
  {

  }

  public function matchBySearch()
  {

  }
}
