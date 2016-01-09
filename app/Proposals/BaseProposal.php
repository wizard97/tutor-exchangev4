<?php
namespace App\Proposals;
use App\Models\Pending\Proposal;

abstract class BaseProposal
{
  protected $prop_model;
  protected $prop;

  public function __construct($prop_id, Proposal $proposal)
  {
    $this->prop_model = $proposal->where('proposal_id', $prop_id)->firstOrFail();
    $this->prop = $proposal;
  }
/*
  public function next_group_id()
  {
    $id = 1;
    $res = $this->prop->orderBy("group_id", 'desc')->first();
    if (!is_null($res)) $id = $res->group_id +1;
    return $id;
  }

  public function set_group_id($id)
  {
    foreach($this->prop_models as $mod)
    {
      $mod->group_id = $id;
    }
  }
  */

}
