<?php
namespace App\Proposals;
use App\Models\Pending\Proposal;
use App\Models\Pending\PendingLevel;
use App\Models\Pending\Status;
use App\Level;
use App\Zip;
use App\User;

class LevelsProposal extends BaseProposal implements ProposalInterface
{
  protected $pendLevels;

  public function __construct(Proposal $prop, Status $status, User $user, PendingLevel $pend_level, Level $level)
  {
    Parent::__construct($prop, $status, $user);
    $this->pend_level = $pend_level;
    $this->level = $level;
  }

  public function load_by_id($pid)
  {
    Parent::load_by_id($pid);

    $this->pendLevels = $this->pend_level->whereIn("proposal_id", $this->prop_ids)
        ->orderBy('level_num', 'asc')->get();

    if (!is_null($this->pendLevels[0]->class_id)) $this->cid = $this->pendLevels[0]->class_id;
    else $this->pend_cid = $this->pendLevels[0]->pending_class_id;

    $this->validate();
  }

  public function create_new($mod_coll = NULL, $cid=NULL, $pending=false, $uid=NULL)
  {
    Parent::create_new($uid);

    $this->pendLevels = $mod_coll;
    $pending ? $this->pend_cid = $cid : $this->cid = $cid;
    $this->uid = $uid;

    // If pending, do I need to make delete requests?
    if (!$pending)
    {
      $lev_ids = $this->pendLevels->pluck('level_id')->reject(function ($item) {
          return is_null($item);
      });

      $to_del = $this->level->where('class_id', $this->cid)->whereNotIn('id', $lev_ids)->get();

      foreach($to_del as $mod)
      {
        $p = new $this->pend_level;
        $p->to_delete = true;
        $p->level_id = $mod->id;
        $p->class_id = $this->cid;
        $p->level_num = $mod->level_num;
        $p->level_name = $mod->level_name;
        // Add the delete operation
        $this->pendLevels->add($p);
      }
    }

    $this->validate();
  }

  public function save()
  {
    try {
      $this->validate();
    } catch (Exception $e) {
      return false;
    }

    if (!Parent::save()) return false;

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

    $this->save();
    return Parent::accept();
  }

  public function reject()
  {

  }
  public function validate()
  {
    $v = true;

    // Make sure proposal is valid
    $v &= Parent::validate();
    if (!$v) throw new \Exception('Proposal is incomplete.');

    // Is it for modifications to an existing class
    if ($this->for_exist_class())
    {
      $levs = $this->level->where('class_id', $this->cid)->get();
      // Make sure no duplicate entries with same level_id for this proposal
      $v &=
      $levs->count() === $this->pendLevels->reject(function ($value) {
            return is_null($value->level_id);
          })->count();

      if (!$v) throw new \Exception('Pending level_ids do not correctly correspond with level ids');

      var_dump($this->pendLevels->pluck('level_id')->toArray());
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
    $v &= !array_has_dupes($this->pend_level->where("proposal_id", $this->prop->id)
          ->orderBy('level_num', 'asc')->where('to_delete', false)->get()->pluck('level_num')->toArray());
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
    return !is_null($this->cid) && !isset($this->pend_cid);
  }

}

function array_has_dupes($array) {
   return count($array) !== count(array_unique($array));
}
