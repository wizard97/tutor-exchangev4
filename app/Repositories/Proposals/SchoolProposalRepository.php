<?php
namespace App\Repositories\Proposals;
use App\Repositories\BaseRepository;
use App\Models\Pending\Proposals;
use App\Models\Pending\PendingSchool;

class SchoolProposalRepository extends BaseRepository
{

  public function _construct(Proposal $p, PendingSchool $s)
  {
    $this->proposal = $p;
    $this->pendingSchool = $s;
    $this->school = null;
    if (!is_null($this->pendingSchool->school)) $this->school =
  }

  public function validate()
  {

  }
}
