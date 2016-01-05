<?php
namespace App\Repositories;
use App\Models\Pending\Proposal;

class ProposalRepository extends BaseRepository
{

  public function _construct(Proposal $prop)
  {
    $this->prop = $prop;
  }
}
