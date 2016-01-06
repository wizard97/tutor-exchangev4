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

  public function __construct(Proposal $prop, Status $status, PendingLevel $pend_level, Level $level,$group_id)
  {
    $this->status = $status;
    $this->pend_level = $pend_level;
    $this->level = $level;
    $this->pendLevels = $pend_level
      ->join('proposals', 'proposals.id', '=', 'pending_levels.proposal_id')
      ->where('group_id', $group_id)
      ->orderBy('level_num', 'asc')->get();
    $this->cid = $this->pendLevels[0]->class_id;
    $this->pend_cid = $this->pendLevels[0]->pending_class_id;
    parent::__construct($group_id, $prop);
    $this->prop_ids = $this->prop_models->pluck('id')->toArray();

    if (!$this->validate())
    {
      throw new \Exception('Validation failed.');
    }

  }

  public function save()
  {

  }

  public function accept()
  {
    foreach($this->pendLevels as $pl)
    {
      //edit existing class levels
      if (!is_null($this->cid))
      {
          //edit level
          if (!is_null($pl->level))
          {
            //delete level?
            if ($pl->proposal->to_delete)
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
  }

  public function reject()
  {

  }
  public function validate()
  {
    $v = true;
    // Make sure no duplicate entries with same level_id for this proposal
    foreach ($this->level->where('class_id', $this->cid)->get() as $l)
    {
      $v &= $l->pending_levels()->whereIn('proposal_id', $this->prop_ids)->count() === 1;
      if (!$v) throw new \Exception('Improper link between existing level and new level.');
      // Make sure existing level's class_id matches new level's class_id
      $v &= $l->class_id === $l->pending_levels()->whereIn('proposal_id', $this->prop_ids)->firstOrFail()->class_id;
      $v &= $l->class_id === $this->cid;
      if (!$v) throw new \Exception("Class ids do not match.");
    }


    foreach ($this->pendLevels as $pl)
    {
      //Existsing class
      if (!is_null($this->cid))
      {
        $v &= !is_null($pl->school_class) && $pl->class_id === $this->cid;
        if (!$v) throw new \Exception('Pending level missing link to existing class.');
      }
      //pending class
      else {
        $v &= !is_null($pl->pending_school_class) && $pl->pending_class_id === $this->pend_cid;
        if (!$v) throw new \Exception('Pending level missing link to pending class.');
        // Make sure pending class is merged
        $v &= !is_null($pl->pending_class()->class);
        if (!$v) throw new \Exception('Pending level has unmerged or missing class.');
      }
    }

    // different level_num
    $v &= !array_has_dupes($this->pendLevels->pluck('level_num')->toArray());
    if (!$v) throw new \Exception("Multiple pending level's with same level number.");

    return $v;
  }

  public function dependencies()
  {

  }

  public function is_edit()
  {

  }

  public function is_saved()
  {

  }

}

function array_has_dupes($array) {
   // streamline per @Felix
   return count($array) !== count(array_unique($array));
}
