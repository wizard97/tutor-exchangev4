<?php
namespace App\Repositories\Proposals\Proposal;

use App\Repositories\BaseRepository;
use App\Models\Proposal\Proposal;
use App\Models\Proposal\BaseProposal;
use App\Repositories\Proposals\Status\StatusRepository;

class ProposalRepository extends BaseRepository implements ProposalRepositoryContract
{

  public function __construct(Proposal $model, StatusRepository $statusRepository)
  {
    $this->model = $model;
    $this->statusRepository = $statusRepository;
  }

  public function getUsersProposals(int $user_id)
  {
      return $this->model->where('user_id', $user_id)->get();
  }


  public function create(int $user_id, BaseProposal $proposable)
  {
    $p = new $this->model;
    $p->status()->associate($this->statusRepository->findBySlug('pend_acpt'));
    $p->user_id = $user_id;
    $p->proposable_type = $proposable->getMorphClass();
    $p->save();
    $p->proposable()->save($proposable);
    return $p;
  }
}
