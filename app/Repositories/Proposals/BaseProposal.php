<?php
namespace App\Repositories\Proposals;
use App\Exception\ProposalException;
use App\Models\Proposal\Status;
use App\Repositories\Proposals\Proposal\ProposalRepository;
use App\Models\Proposal\Proposal;
use App\Models\Proposal\ProposalType;
use App\Models\Proposal\BaseProposal as BaseProposalModel;

abstract class BaseProposal implements ProposalContract
{
  protected $prop;
  protected $model;
  protected $type;

  public function __construct(Proposal $proposal, Status $stat)
  {
    $this->status = $stat;
    $this->prop = new $proposal;
    $this->model = NULL;
  }

  // Returns an instance of BaseProposal
  protected abstract function createProposable($input);
  public abstract function validate(); // throws ProposalException
  public abstract function parent(); // throws ProposalException
  public abstract function children(); // throws ProposalException
  public abstract function getType();



  public function create($uid, $input)
  {
      $this->createProposable($input); //should fill in model field
      $this->prop->type = $this->getType();
      $this->prop->user_id = $uid;
      $this->prop->title = $input['title'];
      $this->prop->status_id = $this->status->getStatusId("pend_acpt");
  }

  public function find($pid)
  {
      $this->prop = $this->prop->findOrFail($pid);
      $this->model = $this->prop->proposal;
  }

  public function save()
  {
      $this->validate();
      \DB::transaction(function () {
          $this->model->save();
          $this->model->proposal()->save($this->prop);
      });
  }


  public function reject()
  {
      foreach ($this->children() as $c)
      {
          $c->reject();
      }
      $this->prop->status()->attach($this->status->getStatusId('rejected'));
  }

  public function accept()
  {
      foreach ($this->children() as $c)
      {
          $c->accept();
      }
      $this->prop->status()->attach($this->status->getStatusId('accepted'));
  }


  public function is_accepted()
  {
    return $this->model->status()->first()->slug === 'accepted';
  }

  public function is_saved()
  {
    return !is_null($this->model->proposal->id);
  }

}
