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

  public function __construct(Proposal $prop, Status $status, Zip $zip, User $user, PendingSchool $pendSchool, School $school)
  {
    Parent::__construct($prop);
    $this->status = $status;
    $this->zip = $zip;
    $this->user = $user;
    $this->pend_school = $pendSchool;
    $this->schl = $school;
  }

  public function load_by_id($pid)
  {
    Parent::load_by_id($pid);
    $this->pend_school_model = $this->prop_model->pending_school;
    $this->update();
  }

  public function create_new($uid = null, $name=null, $zip_id = null, $school_id=null, $to_delete = false)
  {
    Parent::create_new($uid);

    $this->pend_school_model = new $this->pend_school;
    $this->pend_school_model->to_delete = $to_delete;
    $this->pend_school_model->school_name = $name;
    $this->pend_school_model->zip_id = $this->zip->findOrFail($zip_id)->id;
    if(!is_null($school_id))
    {
      $this->pend_school_model->school_id = $this->schl->findOrFail($school_id)->id;
    }
    $this->update();
  }

  public function save($sid = null)
  {
    Parent::save();
    $this->pend_school_model->proposal_id = $this->prop_model->id;
    if (is_null($this->pend_school_model->school)) $this->pend_school_model->school_id = $sid;
    $this->pend_school_model->save();
    $this->update();
    return $this->prop_model->id;
  }

  public function accept()
  {
    try {
      $this->validate();
    } catch (Exception $e) {
      return false;
    }

    $sid = null;

    if($this->is_edit())
    {
      //delete?
      if ($this->pend_school_model->to_delete)
      {
        $this->school_model->delete();
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
    $this->save($sid);
    return Parent::accept();
  }


  public function validate()
  {
    $this->update();

    $p = true;

    // Make sure proposal is valid
    $p &= Parent::validate();

    // Make sure school_id is set if edit
    if ($this->is_edit())
    {
      $p &= !is_null($this->pend_school_model->school()->first());
      if (!$p) throw new \Exception('Trying to edit an unknown school.');
    }
    else {
      //must be false
      $p &= $this->pend_school_model->to_delete === false;
      if (!$p) throw new \Exception('Can not delete an unknown school.');
    }

    $p &= !is_null($this->pend_school_model->zip);
    if (!$p) throw new \Exception('Unknown zip_id.');
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
    return !is_null($this->pend_school_model->proposal_id);
  }

  private function update()
  {
    // Can be null
    $this->school_model = $this->pend_school_model->school()->first();
    $this->is_edit = !is_null($this->school_model);
  }
}
