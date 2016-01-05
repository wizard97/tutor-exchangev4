<?php
namespace App\Proposals;
use App\Models\Pending\Proposal;

abstract class BaseProposal
{
  protected $prop_models;
  protected $prop;

  public function __construct($group_id, Proposal $proposal)
  {
    $this->prop_models = $proposal->where('group_id', $group_id)->get();
    $this->prop = $proposal;
  }

  public function next_group_id()
  {
    $id = 1;
    $res = $this->prop->orderBy("group_id", 'desc')->first();
    if (!is_null($res)) $id = $res->group_id +1;
    return $id;
  }

  public function set_group_id($id)
  {
    $this->prop->group_id = $id;
  }

}
