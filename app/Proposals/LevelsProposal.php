<?php
namespace App\Proposals;
use App\Models\Pending\Proposal;
use App\Models\Pending\PendingLevel;
use App\Models\Pending\Status;
use App\Level;
use App\Zip;
use App\User;
use Illuminate\Database\Eloquent\Collection;

class LevelsProposal extends BaseProposal implements ProposalInterface
{
  protected $pendLevels;

  public function __construct(Proposal $prop, Status $status, PendingLevel $pend_level, Level $level, $pid=NULL,
    //If constructing, rather than retrieving from db
    $mod_coll = NULL, $cid=NULL, $pending=false, $uid=NULL)
  {
    $this->status = $status;
    $this->pend_level = $pend_level;
    $this->level = $level;

    // retrieve everything by group_id
    if (!is_null($pid))
    {
      parent::__construct($pid, $prop);

      $this->pendLevels =
          $pend_level->whereIn("proposal_id", $this->prop_ids)->orderBy('level_num', 'asc')->get();

      if (!is_null($this->pendLevels[0]->class_id)) $this->cid = $this->pendLevels[0]->class_id;
      else $this->pend_cid = $this->pendLevels[0]->pending_class_id;
    }
    else
    {
      $this->pendLevels = $mod_coll;
      $this->prop = $prop;
      $pending ? $this->pend_cid = $cid : $this->cid = $cid;
      $this->uid = $uid;

      // If pending, do I need to make delete requests?

      if (!$pending)
      {
        $lev_ids = $this->pendLevels->pluck('level_id');
        $to_del = $this->level->where('class_id', $this->cid)->whereNotIn('id', $lev_ids)->get();

        foreach($to_del as $mod)
        {
          $p = new $this->pend_level;
          $p->to_delete = true;
          $p->class_id = $this->cid;
          $p->level_num = $mod->level_num;
          $p->level_name = $mod->level_name;
          // Add the delete operation
          $this->pendLevels.add($p);
        }
      }

      //Create the proposal model, unable to set id until saved
      $this->prop_model = new $this->prop;
      $this->prop_model->status_id = $this->status->where('slug', "pending")->firstOrFail()->id;
      $this->prop_model->user_id = $this->user->findOrFail($this->uid)->id;
    }
    $this->validate();
  }

  public function save()
  {
    $this->validate();
    $this->prop_model->save();

    foreach($this->pendLevels as $pl)
    {
      $pl->proposal_id = $this->prop_model->id;
      $pl->save();
    }

    return true;
  }

  public function accept()
  {
    try {
      $this->validate();
    } catch (Exception $e) {
      return false;
    }

    foreach($this->pendLevels as $pl)
    {
      //edit existing class levels
      if (!is_null($this->cid))
      {
          //edit level
          if (!is_null($pl->level))
          {
            //delete level?
            if ($pl->to_delete)
            {
              $pl->level->delete();
              $pl->level_id = null;
              $pl->save();
              continue;
            }
            $lev = $pl->level;
          }
          //insert new level to existing class
          else {
            $lev = new $this->level;
            $lev->class_id = $this->cid;
          }
      }
      // From pending class
      else {
        // lookup id
        $merge_cid = $this->pendLevels[0]->pending_school_class()->school_class->id;
        $lev = new $this->level;
        $lev->class_id = $merge_cid;
      }
      $lev->level_num = $pl->level_num;
      $lev->level_name = $pl->level_name;
      //save
      $lev->save();
    }
    //update status
    $status_id = $this->status->where('slug', 'accepted')->firstOrFail()->id;
    $this->prop->where('group_id', $this->gid)->update(['status' => $status_id]);
    return true;
  }

  public function reject()
  {

  }
  public function validate()
  {
    $v = true;

    // Is it for modifications to an existing class
    if ($this->for_exist_class())
    {
      $levs = $this->level->where('class_id', $this->cid)->get();
      // Make sure no duplicate entries with same level_id for this proposal
      $v &=
      $levs->count() === $this->pendLevels->reject(function ($value, $key) {
            return is_null($value->level_id);
          })->count();
      if (!$v) throw new \Exception('Pending level_ids do not correctly correspond with level ids');

      foreach ($levs as $l)
      {
          $v &= $this->pendLevels->pluck('level_id')->contains($l->id);
          $v &= $l->class_id === $this->cid;
      }
      if (!$v) throw new \Exception('Improper link between existing level and new level.');

      foreach ($this->pendLevels as $pl)
      {
        $v &= !is_null($pl->school_class) && $pl->class_id === $this->cid;
        if (!$v) throw new \Exception('Pending level missing link to existing class.');
      }
    }
    // Requests for levels for a pending class
    else
    {
      foreach ($this->pendLevels as $pl)
      {
        $v &= !is_null($pl->pending_school_class) && $pl->pending_class_id === $this->pend_cid;
        if (!$v) throw new \Exception('Pending level missing link to pending class.');
        // Make sure pending class is merged
        $v &= !is_null($pl->pending_class()->class);
        if (!$v) throw new \Exception('Pending level has unmerged or missing class.');
      }
    }

    // different level_num, exclude ones pending for delete
    $v &= !array_has_dupes($pend_level->where("proposal_id", $this->prop->id)
          ->orderBy('level_num', 'asc')->where('to_delete', false)->get()->pluck('level_num')->toArray();
    if (!$v) throw new \Exception("Multiple pending level's with same level number.");

    return $v;
  }

  public function dependencies()
  {

  }

  public function is_edit()
  {
    return true;
  }

  public function is_saved()
  {
    return !is_null($this->prop_model->id);
  }

  private function for_exist_class()
  {
    return !is_null($this->cid) && is_null($this->pend_cid);
  }

}

function array_has_dupes($array) {
   return count($array) !== count(array_unique($array));
}

// Need to create an array of proposal models
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
      $p->_class_id = $this->cid;
    }
    //append it
    $this->levelModels.add($p);
  }

  public function createLevelsProposal()
  {
    return new LevelsProposal($mod_coll = $this->levelModels, $cid=$this->cid, $pending=$this->pending, $uid=$this->uid);
  }
}
