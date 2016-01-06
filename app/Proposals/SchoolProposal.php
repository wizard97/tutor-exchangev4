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
  protected $schl;

  protected $pend_school_model;
  protected $school_model;

  // True if editing, false if new
  protected $is_edit;

  public function __construct(Proposal $prop, Status $status, Zip $zip, User $user, PendingSchool $pendSchool, School $school,
      $gid=null, $uid = null, $name=null, $zip_id = null, $school_id=null)
  {
    $this->status = $status;
    $this->zip = $zip;
    $this->user = $user;
    $this->pend_school = $pendSchool;
    $this->schl = $school;

    if (!is_null($gid))
    {
      parent::__construct($gid, $prop);
      $this->pend_school_model = $this->prop_models[0]->pending_school;
    }
    else
    {
      $this->prop = $prop;
      $this->prop_models[0] = new $prop;
      // Figure out if updating or adding new listing
      $this->prop_models[0]->status_id = $this->status->where('slug', 'pend_acpt')->firstOrFail()->id;
      $this->prop_models[0]->user_id = $this->user->findOrFail($uid)->id;

      $this->pend_school_model = new $pendSchool;
      $this->pend_school_model->school_name = $name;
      $this->pend_school_model->zip_id = $this->zip->findOrFail($zip_id)->id;
      if(!is_null($school_id))
      {
        $this->pend_school_model->school_id = $this->schl->findOrFail($school_id)->id;
      }
    }

    $this->update();
  }

  public function save($sid = null)
  {
    if(is_null($this->prop_models[0]->group_id)) $this->set_group_id($this->next_group_id());
    $this->prop_models[0]->save();
    $this->pend_school_model->proposal_id = $this->prop_models[0]->id;
    if (is_null($this->pend_school_model->school)) $this->pend_school_model->school_id = $sid;
    $this->pend_school_model->save();
    $this->update();
  }

  public function accept()
  {
    if (!$this->validate()) return false;

    if($this->is_edit())
    {
      //delete?
      if ($this->prop_models[0]->to_delete)
      {
        $this->school_model->delete();
        $sid = null;
      }
      else {
        //update attributes
        $this->school_model->zip_id = $this->pend_school_model->zip_id;
        $this->school_model->school_name = $this->pend_school_model->school_name;
        $this->school_model->save();
        $sid = $this->school_model->id;
      }

    }
    else {
      $to_save = new $this->schl;
      $to_save->zip_id = $this->pend_school_model->zip_id;
      $to_save->school_name = $this->pend_school_model->school_name;
      $to_save->save();
      $sid = $to_save->id;
    }
    $this->prop_models[0]->status_id = $this->status->where('slug', 'accepted')->firstOrFail()->id;
    $this->save($sid);
    return true;
  }

  public function reject()
  {
    $this->prop_models[0]->status_id = $this->status->where('slug', 'rejected')->firstOrFail()->id;
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
    return !is_null($this->prop_models[0]->id);
  }

  private function update()
  {
    // Can be null
    $this->school_model = $this->pend_school_model->school()->first();
    $this->is_edit = !is_null($this->school_model);
  }
}
