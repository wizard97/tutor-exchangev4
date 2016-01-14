<?php
namespace App\Repositories\Proposals;
use App\Models\Pending\Proposal;
use App\Models\Pending\Status;
use App\User;
use App\School;
use App\Models\Pending\PendingSchool;

use App\SchoolSubject;
use App\Models\Pending\PendingSchoolSubject;

use App\SchoolClass;
use App\Models\Pending\PendingClass;

class SchoolClassProposal extends BaseProposal implements ProposalContract
{
  protected $pendSchool;
  protected $school;
  protected $schoolSubject;
  protected $pendSchoolSubject;
  protected $pend_ss_mod;


  public function __construct(Proposal $prop, Status $status, User $user,
      School $school, PendingSchool $pendSchool,
      SchoolSubject $schoolSubject, PendingSchoolSubject $pendSchoolSubject,
      SchoolClass $class, PendingClass $pendingClass,
      )
  {
    Parent::__construct($prop, $status, $user);
    $this->school = $school;
    $this->pendSchool = $pendSchool;

    $this->schoolSubject = $schoolSubject;
    $this->pendSchoolSubject = $pendSchoolSubject;

    $this->class = $class;
    $this->pendingClass = $pendingClass;
  }

  public function load_by_id($pid)
  {
    Parent::load_by_id($pid);
    $this->pend_class = $this->prop_model->pending_class;
    // Validate without checking for depedencies
    $this->validate(false);
  }

  public function create_new($uid = null, $class_name=null,
      $school_pending=false, $school_id=null, $subject_pending,
      $subject_id=null, $class_id=null, $to_delete = false)
  {
    // Create a new base proposal
    Parent::create_new($uid);
    // Create a new class proposal
    $cl = new $this->pendClass;
    // Is the school it is a part of pending?
    $school_pending ? $cl->pending_school_id = $school_id : $cl->school_id = $school_id;
    // Is the subejct it is a part of pending?
    $subject_pending ? $cl->pending_subject_id = $subject_id : $cl->subject_id = $subject_id;
    // Are you editing an existing class
    $cl->class_id = $class_id;
    // Are you trying to delete the entire class listing?
    $cl->to_delete = $to_delete;
    $cl->class_name = $class_name;

    // if deleting, load the info from the existing model as a record
    if ($to_delete)
    {
      $cl->school_id = $cl->school_class->school_id;
      $cl->class_name = $cl->school_class->class_name;
    }
    $this->pend_class = $cl;
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
    if (!$this->is_saved()) $this->pend_class->proposal_id = $this->prop_model->id;
    $this->pend_class->save();
    return $this->pend_class->id;
  }

  public function accept()
  {
    $this->validate();

    Parent::accept();

    // Is it an edit for a delete?
    if ($this->is_edit() && $this->pend_class->to_delete)
    {
      $this->pend_class->school_class->delete();
      $this->pend_class->class_id = NULL;
      $this->pend_class->save();
    }
    else //New insert or edit
    {
      // If edit load the existing sub model, otherwise load a blank one to insert
      $this->is_edit() ? $cl = $this->pend_class->school_class : $cl = new $this->class;

      // Only update school_id if you know the id of the school directly, either new insert or edit
      if ($this->for_exist_school()) $cl->school_id = $this->pend_class->school->id;
      // New insert, with pending school (that should be accepted), so resolve school_id
      else if (!$this->is_edit()) $cl->school_id = $this->pend_class->pending_school->school->id;

      // If the subject_id is known set it
      if ($this->for_exist_subject()) $cl->subject_id = $this->pend_class->subject->id
      // Otherwise resolve it through the pending_subject
      else if (!$this->is_edit()) $cl->subject_id = $this->pend_class->pending_subject->id;
      // Update the name
      $cl->class_name = $this->pend_class->class_name;
      $cl->save();
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
