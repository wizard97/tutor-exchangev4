<?php
namespace App\Repositories\Messenger\Participant;

use App\Repositories\BaseRepository;

use App\Models\Messenger\Participant;

class ParticipantRepository extends BaseRepository implements ParticipantRepositoryContract
{

  public function __construct(Participant $model)
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
