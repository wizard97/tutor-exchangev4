<?php
namespace App\Repositories\Proposals;
use App\Models\Pending\Proposal;
use App\Models\Pending\PendingSchool;
use App\Models\Pending\PendingSchoolSubject;
use App\Models\Pending\Status;
use App\School;
use App\User;
use App\SchoolSubject;

class SchoolSubjectProposal extends BaseProposal implements ProposalContract
{
  protected $pendSchool;
  protected $school;
  protected $schoolSubject;
  protected $pendSchoolSubject;
  protected $pend_ss_mod;


  public function __construct(Proposal $prop, Status $status, User $user,
      School $school, PendingSchool $pendSchool,
      SchoolSubject $schoolSubject, PendingSchoolSubject $pendSchoolSubject)
  {
    Parent::__construct($prop, $status, $user);
    $this->pendSchool = $pendSchool;
    $this->school = $school;
    $this->schoolSubject = $schoolSubject;
    $this->pendSchoolSubject = $pendSchoolSubject;
  }

  public function load_by_id($pid)
  {
    Parent::load_by_id($pid);
    $this->pend_ss_mod = $this->prop_model->pending_school_subject;
    // Validate without checking fro depedencies
    $this->validate(false);
  }

  public function create_new($uid = null, $subject_name=null,
      $pending=false, $school_id=null, $sub_id=null, $to_delete = false)
  {
    Parent::create_new($uid);
    $sub = new $this->pendSchoolSubject;
    $pending ? $sub->pending_school_id = $school_id : $sub->school_id = $school_id;
    $sub->school_subject_id = $sub_id;
    $sub->to_delete = $to_delete;
    $sub->subject_name = $subject_name;

    if ($to_delete)
    {
      $sub->school_id = $sub->school_subject->school_id;
      $sub->subject_name = $sub->school_subject->subject_name;
    }
    $this->pend_ss_mod = $sub;
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
    if (!$this->is_saved()) $this->pend_ss_mod->proposal_id = $this->prop_model->id;
    $this->pend_ss_mod->save();
    return $this->prop_model->id;
  }

  public function accept()
  {
    $this->validate();

    Parent::accept();

    // Is it an edit for a delete?
    if ($this->is_edit() && $this->pend_ss_mod->to_delete)
    {
      $this->pend_ss_mod->school_subject->delete();
      $this->pend_ss_mod->school_subject_id = NULL;
      $this->pend_ss_mod->save();
    }
    else //New insert or edit
    {
      // If edit load the existing sub model
      $this->is_edit() ? $sub = $this->pend_ss_mod->school_subject : $sub = new $this->schoolSubject;

      // Only update school_id if new insert
      if ($this->for_exist_school()) $sub->school_id = $this->pend_ss_mod->school->id;
      else if (!$this->is_edit()) $sub->school_id = $this->pend_ss_mod->pending_school->school->id;

      // Update the name
      $sub->subject_name = $this->pend_ss_mod->subject_name;
      $sub->save();
    }

    //Save it

    return $this->save_helper();
  }


  public function validate($dependencies=true)
  {
    $p = true;
    // Make sure proposal is valid
    $p &= Parent::validate();

    // One or the other must be set, but not both
    $p &= (!is_null($this->pend_ss_mod->pending_school_id) xor !is_null($this->pend_ss_mod->school_id));
    if (!$p) throw new \Exception('Only one of school_id or pending_school_id can be set.');

    if ($this->is_edit()) //editing an existing subject, must have an existing school
    {
      // Are there any pending edits?
      $sid = $this->status->where('slug', 'pend_acpt')->firstOrFail()->id;
      $qry = $this->pendSchoolSubject
          ->join('proposals', 'proposals.id', '=', 'pending_school_subjects.proposal_id')
          ->where('proposals.status_id', $sid)
          ->where('pending_school_subjects.school_subject_id', $this->pend_ss_mod->school_subject_id);

      if ($this->is_saved())
      {
        $qry->where('pending_school_subjects.proposal_id', '!=', $this->prop_model->id);
      }
      $count =$qry->get()->count();
      if ($count !== 0) throw new \Exception('There are existing pending edits for this school subject.');

      $p &= !is_null($this->pend_ss_mod->school_subject()->first());
      if (!$p) throw new \Exception('Trying to edit an unknown subject.');

      $p &= $this->pend_ss_mod->school_id === $this->pend_ss_mod->school_subject->school_id;
      if (!$p) throw new \Exception('The school_id attribute is incorrect.');

      $p = !is_null($this->pend_ss_mod->school);
      if (!$p) throw new \Exception('No school found.');
    }
    else //Inserting a new subject for pending or existing school
    {
      //must be false
      $p &= $this->pend_ss_mod->to_delete == false;
      if (!$p) throw new \Exception('The delete option can not be set for an insert.');
      // For exisitng school
      if ($this->for_exist_school())
      {
        //Make sure existing_school exists
        $p = !is_null($this->pend_ss_mod->school);
        if (!$p) throw new \Exception('No school found.');
      }
      else // for pending school
      {
        //Make sure pending_school exists
        $p = !is_null($this->pend_ss_mod->pending_school);
        if (!$p) throw new \Exception('No pending school found.');

        if ($dependencies)
        {
          $p &= $this->pend_ss_mod->pending_school->proposal->status->slug == 'accepted';
          if (!$p) throw new \Exception('Pending school is not merged.');
          $p &= !is_null($this->pend_ss_mod->pending_school->school);
          if (!$p) throw new \Exception('Pending school has missing link to merged school.');
        }

      }
    }
    return $p;
  }

  public function dependencies()
  {
    // Is pending school merged if applicable?
    if (! $this->for_exist_school() && is_null($this->pend_ss_mod->pending_school->school))
    {
      return [$this->pend_ss_mod->pending_school->proposal->id];
    }

    return [];
  }

  // Are you editing a school subject, or creating a new one?
  public function is_edit()
  {
    return !is_null($this->pend_ss_mod->school_subject_id);
  }

  public function is_saved()
  {
    return !is_null($this->pend_ss_mod->id) && Parent::is_saved();
  }

  private function for_exist_school()
  {
    return !is_null($this->pend_ss_mod->school);
  }

}
