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
    Parent::__construct($prop, $status, $user);
    $this->zip = $zip;
    $this->pend_school = $pendSchool;
    $this->schl = $school;
  }

  public function load_by_id($pid)
  {
    Parent::load_by_id($pid);
    $this->pend_school_model = $this->prop_model->pending_school;
    $this->update();
    $this->validate();
  }

  public function create_new($uid = null, $name=null, $zip_id = null, $school_id=null, $to_delete = false)
  {
    Parent::create_new($uid);

    $this->pend_school_model = new $this->pend_school;
    $this->pend_school_model->to_delete = $to_delete;

    if (!is_null($school_id)) $this->pend_school_model->school_id = $school_id;

    if ($to_delete)
    {
      $scl = $this->schl->findOrFail($school_id);
      $this->pend_school_model->school_name = $scl->school_name;
      $this->pend_school_model->zip_id = $scl->zip_id;
    }
    else {
      $this->pend_school_model->school_name = $name;
      $this->pend_school_model->zip_id = $this->zip->findOrFail($zip_id)->id;
    }
    $this->update();
    $this->validate();
  }

  public function save()
  {
    $this->validate();
    return $this->save_helper();
  }

  protected function save_helper()
  {
    Parent::save_helper();

    $this->pend_school_model->proposal_id = $this->prop_model->id;
    $this->pend_school_model->save();
    $this->update();
    return $this->prop_model->id;
  }

  public function accept()
  {
    $this->validate();
    Parent::accept();

    $sid = null;

    if($this->is_edit())
    {
      //delete?
      if ($this->pend_school_model->to_delete)
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

    $this->pend_school_model->school_id = $sid;
    // Save without validation
    $this->save_helper();
    $this->update();
    return $this->prop_model->id;
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
      // Are there any pending edits?
      $sid = $this->status->where('slug', 'pend_acpt')->firstOrFail()->id;
      $qry = $this->pend_school
          ->join('proposals', 'proposals.id', '=', 'pending_schools.proposal_id')
          ->where('proposals.status_id', $sid)
          ->where('pending_schools.school_id', $this->pend_school_model->school_id);

      if ($this->is_saved())
      {
        $qry->where('pending_schools.proposal_id', '!=', $this->prop_model->id);
      }
      $count =$qry->get()->count();
      if ($count !== 0) throw new \Exception('There are existing pending edits for school.');

      $p &= !is_null($this->pend_school_model->school()->first());
      if (!$p) throw new \Exception('Trying to edit an unknown school.');
    }
    else
    {
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
