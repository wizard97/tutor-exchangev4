<?php
namespace App\Repositories\Messenger\Thread;

use App\Repositories\BaseRepository;

use App\Models\Messenger\Thread;

class ThreadRepository extends BaseRepository implements ThreadRepositoryContract
{

  public function __construct(Thread $model)
  {
    $this->model = $model;
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
