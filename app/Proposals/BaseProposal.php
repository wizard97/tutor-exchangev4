<?php
namespace App\Proposals;
use App\Models\Pending\Proposal;

abstract class BaseProposal
{
  protected $prop_model;
  protected $prop;

  public function __construct(Proposal $proposal)
  {
    $this->prop = $proposal;
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
    $this->prop_model->save();
  }

  public function reject()
  {
    $this->prop_model->status_id = $this->status->where('slug', 'rejected')->firstOrFail()->id;
    $this->prop_model->save();
    return $this->prop_model->id;
  }

  public function accept()
  {
    $this->prop_model->status_id = $this->status->where('slug', 'accepted')->firstOrFail()->id;
    $this->prop_model->save();

    return $this->prop_model->id;
  }

  public function validate()
  {
    $p = true;

    $p &= !is_null($this->prop_model->status);
    if (!$p) throw new \Exception('Unknown status.');

    $p &= !is_null($this->prop_model->user);
    if (!$p) throw new \Exception('Unknown user.');
    return $p;
  }

}
