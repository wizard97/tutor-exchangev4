<?php
namespace App\Repositories\Proposals;
use App\Models\Pending\Proposal;
use App\User;
use App\Models\Pending\Status;

abstract class BaseProposal implements ProposalContract
{
  protected $prop_model;
  protected $prop;

  public function __construct(Proposal $proposal, Status $status, User $user)
  {
    $this->prop = $proposal;
    $this->status = $status;
    $this->user = $user;
  }

  public function load_by_id($prop_id)
  {
    $this->prop_model = $this->prop->where('id', $prop_id)->firstOrFail();
  }

  public function create_new($uid)
  {
    $this->prop_model = new $this->prop;
    // Figure out if updating or adding new listing
    $this->prop_model->status_id = $this->status->where('slug', 'pend_acpt')->firstOrFail()->id;
    $this->prop_model->user_id = $this->user->findOrFail($uid)->id;
  }

  public function save()
  {
    $this->validate();
    return $this->save_helper();
  }
  protected function save_helper()
  {
    $this->prop_model->save();
    return $this->prop_model->id;
  }

  public function reject()
  {
    $this->prop_model->status_id = $this->status->where('slug', 'rejected')->firstOrFail()->id;
    $this->prop_model->save();
    return $this->prop_model->id;
  }

  public function accept()
  {
    $this->validate();
    $this->prop_model->status_id = $this->status->where('slug', 'accepted')->firstOrFail()->id;
    $this->prop_model->save();

    return $this->prop_model->id;
  }

  public function validate()
  {

    $p = true;

    $p &= !is_null($this->prop_model->status);
    if (!$p) throw new \Exception('Unknown status.');

    $p &= $this->prop_model->status()->first()->slug === 'pend_acpt';
    if (!$p) throw new \Exception('The request is closed.');

    $p &= !is_null($this->prop_model->user);
    if (!$p) throw new \Exception('Unknown user.');
    return $p;
  }

  public function is_accepted()
  {
    return $this->prop_model->status()->first()->slug === 'accepted';
  }

  public function is_saved()
  {
    return !is_null($this->prop_model->id);
  }

}
