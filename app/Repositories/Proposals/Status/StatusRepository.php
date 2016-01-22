<?php
namespace App\Repositories\Proposals\Status;

use App\Repositories\BaseRepository;

use App\Models\Pending\Status;

class StatusRepository extends BaseRepository implements StatusRepositoryContract
{

  public function __construct(Status $model)
  {
    $this->model = $model;
  }

  public function findBySlug($slug)
  {
    return $this->model->where('slug', '=', $slug)->firstOrFail();
  }
}
