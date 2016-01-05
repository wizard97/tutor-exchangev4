<?php
namespace App\Proposals;
use App\Models\Pending\Proposal;
use App\Models\Pending\PendingSchool;
use App\Models\Pending\Status;
use App\School;
use App\Zip;
use App\User;

class SchoolProposal extends BaseProposal implements ProposalInterface
{
  protected $pendLevels;

  public function __construct(Proposal $prop, Status $status, $group_id)
  {
    $this->status = $status;
    //make sure each level entry has corresponding replacement
    $this->pendLevels = $prop->where('group_id', $group_id)->orderBy('level_num', 'asc')->get();
    foreach ($pendingLevels as $level) assert(!is_null($level->level));

  }

  public function save()
  {
    foreach($this->pendLevels as $level)
    {
      $this->update_level($level);
    }

  }

  public function reject()
  {

  }
  public function validate()
  {

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

  private function update_level($proposal)
  {
    $listing = $proposal->level();
    $listing->level_num = $proposal->level_num;
    $listing->level_name = $proposal->level_name;
    $listing->save();

  }
}
