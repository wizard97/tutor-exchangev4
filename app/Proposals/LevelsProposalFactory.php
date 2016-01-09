<?php
namespace App\Proposals;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Pending\PendingLevel;

class LevelsProposalFactory
{
  protected $level;
  protected $levelModels;
  protected $cid;
  protected $num;
  protected $uid;

  public function __construct(PendingLevel $plevel, $uid, $cid, $pending)
  {
    $this->plevel = $plevel;
    $this->cid = $cid;
    $this->pending = $pending;
    // initialize it empty
    $this->levelModels = new Collection;
    $this->num = 1;
    $this->uid = $uid;
  }

  public function addNextLevel($lid=NULL, $l_name)
  {
    // Append to array
    $p = new $this->plevel;
    $p->level_id = $lid;
    $p->level_name = $l_name;
    $p->level_num = $this->num++;

    // Is it a pending class?
    if ($this->pending)
    {
      $p->pending_class_id = $this->cid;
    }
    else {
      $p->class_id = $this->cid;
    }
    //append it
    $this->levelModels->add($p);
  }

  public function createLevelsProposal($proposal)
  {
    return $proposal->create_new($mod_coll = $this->levelModels, $cid=$this->cid, $pending=$this->pending, $uid=$this->uid);
  }
}
