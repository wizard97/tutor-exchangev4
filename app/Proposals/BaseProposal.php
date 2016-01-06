<?php
namespace App\Proposals;
use App\Models\Pending\Proposal;

abstract class BaseProposal
{
  protected $prop_models;
  protected $prop;
  protected $prop_ids;
  protected $gid;

  public function __construct($group_id, Proposal $proposal)
  {
    $this->prop_models = $proposal->where('group_id', $group_id)->get();
    if ($this->prop_models->isEmpty()) throw new \Exception('Proposal is empty.');
    $this->prop_ids = $this->prop_models->pluck('id')->toArray();
    $this->prop = $proposal;
    $this->gid = $group_id;
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
    foreach($this->prop_models as $mod)
    {
      $mod->group_id = $id;
    }
  }

}
