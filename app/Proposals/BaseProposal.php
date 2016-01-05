<?php
namespace App\Proposals;
use App\Models\Pending\Proposal;

abstract class BaseProposal
{
  protected $proposal_model;

  public function __construct($prop_id, Proposal $proposal)
  {
    $this->proposal_model = $proposal->findOrFail($prop_id);
  }
}
