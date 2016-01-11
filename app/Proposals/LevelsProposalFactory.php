<?php
namespace App\Proposals;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Pending\PendingLevel;
use App\Proposals\LevelsProposal;

class LevelsProposalFactory
{
  // Passed in through constructor
  protected $plevel;
  protected $levProp;
  protected $uid;
  protected $cid;
  protected $pending;

  // attributes
  protected $num;
  protected $levelModels;

  public function __construct(PendingLevel $pLevel, LevelsProposal $levProp, $uid, $cid, $pending)
  {
    $this->pLevel = $pLevel;
    $this->levProp = $levProp;
    $this->uid = $uid;
    $this->cid = $cid;
    $this->pending = $pending;
    // initialize it empty
    $this->levelModels = new Collection;
    $this->num = 1;
  }

  public function addNextLevel($lid=NULL, $l_name)
  {
    // Append to array
    $p = new $this->pLevel;
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

  public function createLevelsProposal()
  {
    $this->levProp->create_new($mod_coll = $this->levelModels, $cid=$this->cid, $pending=$this->pending, $uid=$this->uid);
    return $this->levProp;
  }
}
