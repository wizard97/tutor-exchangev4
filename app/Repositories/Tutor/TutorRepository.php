<?php
namespace App\Repositories\Tutor;

use App\Repositories\BaseRepository;

use App\Models\Tutor\Tutor;

class TutorRepository extends BaseRepository implements TutorRepositoryContract
{

  public function __construct(Tutor $model)
  {
    $this->model = $model;
  }

}
