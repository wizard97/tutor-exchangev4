<?php
namespace App\Repositories\Proposals\School;
use App\Models\Pending\PendingSchool;

class SchoolProposalRepository implements SchoolProposalRepositoryContract
{

  public function __construct(PendingSchool $pendingSchool)
  {
    $this->pendingSchool = $pendingSchool;
  }

  public function store($inputs, $user_id)
  {
    $proposal = new $this->pendingSchool;

    if ($inputs['proposal_type'] == 'create')
    {

    }
    else if ($inputs['proposal_type'] == 'edit')
    {

    }
    else if ($inputs['proposal_type'] == 'delete')
    {

    }
  }
}
