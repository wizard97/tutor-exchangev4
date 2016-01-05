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
  protected $status;
  protected $zip;
  protected $user;

  protected $pend_school;
  protected $school;

  protected $pend_school_model;
  protected $school_model;

  // True if editing, false if new
  protected $is_edit;

  public function __construct(Proposal $prop, Status $status, Zip $zip, User $user, PendingSchool $pendSchool, School $school,
      $pid=null, $uid = null, $name=null, $zip_id = null, $school_id=null)
  {
    $this->status = $status;
    $this->zip = $zip;
    $this->user = $user;
    $this->pend_school = $pendSchool;
    $this->school = $school;

    if (!is_null($pid))
    {
      parent::__construct($pid, $prop);
      $this->pend_school_model = $this->proposal_model->pending_school;
    }
    else
    {
      $this->proposal_model = new $prop;
      // Figure out if updating or adding new listing
      $this->proposal_model->status_id = $this->status->where('slug', 'pend_acpt')->firstOrFail()->id;
      $this->proposal_model->user_id = $this->user->findOrFail($uid)->id;

      $this->pend_school_model = new $pendSchool;
      $this->pend_school_model->school_name = $name;
      $this->pend_school_model->zip_id = $this->zip->findOrFail($zip_id)->id;
      if(!is_null($school_id))
      {
        $this->pend_school_model->school_id = $this->school->findOrFail($school_id)->id;
      }
    }

    // Can be null
    $this->school_model = $this->pend_school_model->school;
    $this->is_edit = !is_null($this->school_model);
  }

  public function save()
  {
    $this->proposal_model->save();
    $this->pend_school_model->proposal_id = $this->proposal_model->id;
    $this->pend_school_model->save();
  }

  public function accept()
  {
    if (!$this->validate()) return false;

    if($this->is_edit())
    {
      //update attributes
      $this->school_model->zip_id = $this->pend_school_model->zip_id;
      $this->school_model->school_name = $this->pend_school_model->school_name;
      $this->school_model->save();
    }
    else {
      $to_save = new $this->school;
      $to_save->zip_id = $this->pend_school_model->zip_id;
      $to_save->school_name = $this->pend_school_model->school_name;
      $to_save->save();
    }
    $this->proposal_model->status_id = $this->status->where('slug', 'accepted')->firstOrFail()->id;
    $this->save();
    return true;
  }

  public function reject()
  {
    $this->proposal_model->status_id = $this->status->where('slug', 'rejected')->firstOrFail()->id;
    $this->save();
    return true;
  }
  public function validate()
  {
    return true;
  }
  public function dependencies()
  {
    // no dependencies
    return [];
  }

  public function is_edit()
  {
    return $this->is_edit;
  }

  public function is_saved()
  {
    return !is_null($this->proposal_model->id);
  }
}
