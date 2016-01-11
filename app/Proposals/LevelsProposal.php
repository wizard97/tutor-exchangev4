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
  // Passed in through constructor
  protected $pend_level;
  protected $level;

  // Attributes
  protected $pendLevels;
  protected $cid;
  protected $pend_cid;
  protected $uid;

  public function __construct(Proposal $prop, Status $status, User $user, PendingLevel $pend_level, Level $level)
  {
    Parent::__construct($prop, $status, $user);
    $this->pend_level = $pend_level;
    $this->level = $level;
  }

  public function load_by_id($pid)
  {
    Parent::load_by_id($pid);

    $this->pendLevels = $this->pend_level->where("proposal_id", $this->prop_model->id)
        ->orderBy('level_num', 'asc')->get();

    if (!is_null($this->pendLevels[0]->class_id)) $this->cid = $this->pendLevels[0]->class_id;
    else $this->pend_cid = $this->pendLevels[0]->pending_class_id;
    $this->validate(false);
  }

  public function create_new($mod_coll = NULL, $cid=NULL, $pending=false, $uid=NULL)
  {
    Parent::create_new($uid);

    $this->pendLevels = $mod_coll;
    $this->cid = null;
    $this->pend_cid = null;
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
    $this->validate(false);
  }

  public function save()
  {
    $this->validate(false);

    return $this->save_helper();
  }

  protected function save_helper()
  {
    Parent::save_helper();

    foreach($this->pendLevels as $pl)
    {
      $pl->proposal_id = $this->prop_model->id;
      $pl->save();
    }

    return $this->prop_model->id;
  }

  public function accept()
  {
    $this->validate();
    Parent::accept();

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
              $pl->level_id = NULL;
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
        $merge_cid = $this->pendLevels[0]->pending_school_class->school_class->id;
        $lev = new $this->level;
        $lev->class_id = $merge_cid;
      }
      $lev->level_num = $pl->level_num;
      $lev->level_name = $pl->level_name;
      //save
      $lev->save();
      //update the id to point to the insert/edit
      $pl->level_id = $lev->id;
      $pl->save();
    }

    return $this->save_helper();
  }

  public function reject()
  {

  }
  public function validate($dependencies=true)
  {
    $v = true;

    // Make sure proposal is valid
    $v &= Parent::validate();
    if (!$v) throw new \Exception('Proposal is incomplete.');

    // no models in collection
    if ($this->pendLevels->count() <= 0) throw new \Exception('No level models to change.');

    // Is it for modifications to an existing class
    if ($this->for_exist_class())
    {
      // Pending entries for this class
      $sid = $this->status->where('slug', 'pend_acpt')->firstOrFail()->id;

      $qry = $this->pend_level
          ->join('proposals', 'proposals.id', '=', 'pending_levels.proposal_id')
          ->where('proposals.status_id', $sid)
          ->where('pending_levels.class_id', $this->cid);

      if ($this->is_saved())
      {
        $qry->where('pending_levels.proposal_id', '!=', $this->prop_model->id);
      }

      $count =$qry->get()->count();

      if ($count !== 0) throw new \Exception('There are existing pending level proposals for this class.');

      $levs = $this->level->where('class_id', $this->cid)->get();
      // Make sure no duplicate entries with same level_id for this proposal
      $v &=
      $levs->count() === $this->pendLevels->reject(function ($value) {
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
      // Are there pending entries for this class?
      $sid = $this->status->where('slug', 'pend_acpt')->firstOrFail()->id;
      $qry = $this->pend_level
          ->join('proposals', 'proposals.id', '=', 'pending_levels.proposal_id')
          ->where('proposals.status_id', $sid)
          ->where('pending_levels.pending_class_id', $this->pend_cid);

      if ($this->is_saved())
      {
        $qry->where('pending_levels.proposal_id', '!=', $this->prop_model->id);
      }

      $count =$qry->get()->count();

      if ($count !== 0) throw new \Exception('There are existing pending level proposals for this pending class.');

      foreach ($this->pendLevels as $pl)
      {
        $v &= !is_null($pl->pending_school_class) && $pl->pending_class_id === $this->pend_cid;
        if (!$v) throw new \Exception('Pending level missing link to pending class.');

        // Should we check if the pending class is merged?
        if ($dependencies)
        {
          // Make sure pending class is merged
          $sid = $this->status->where('slug', 'accepted')->first->id;
          $v &= !is_null($pl->pending_school_class->school_class) &&
              $pl->pending_school_class->status->id === $sid;
          if (!$v) throw new \Exception('Pending level has unmerged or missing class.');
        }
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
    if (!$this->for_exist_class() && is_null($pl->pending_school_class->school_class))
    {
      return [$pl->pending_school_class->proposal_id];
    }
    return [];
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
    return isset($this->cid) && !isset($this->pend_cid);
  }

}

function array_has_dupes($array) {
   return count($array) !== count(array_unique($array));
}
