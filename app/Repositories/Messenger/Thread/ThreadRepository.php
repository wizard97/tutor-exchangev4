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
