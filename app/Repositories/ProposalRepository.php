<?php
namespace App\Repositories;
use App\Models\Pending\Proposals;

class ClassRepository extends BaseRepository
{

  public function _construct(Proposal $p)
  {
    $this->proposal = $p;
  }
}
