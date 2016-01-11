<?php
namespace App\Repositories\Proposals;
use App\Repositories\BaseRepository;
use App\Models\Pending\Proposals;

class ProposalRepository extends BaseRepository
{

  public function _construct(Proposal $p)
  {
    $this->proposal = $p;
  }

  public function validate()
  {

  }
}
