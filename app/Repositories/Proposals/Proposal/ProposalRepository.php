<?php
namespace App\Repositories\Proposals\Proposal;

use App\Repositories\BaseRepository;

use App\Models\Pending\Proposal;

use App\Repositories\Proposals\Status\StatusRepository;

class ProposalRepository extends BaseRepository implements ProposalRepositoryContract
{

  public function __construct(Proposal $model, StatusRepository $statusRepository)
  {
    $this->model = $model;
    $this->statusRepository = $statusRepository;
  }

  public function create($user_id)
  {
    $p = new $this->model;
    $p->status()->associate($this->statusRepository->findBySlug('pend_acpt'));
    $p->user_id = $user_id;
    $p->save();
    return $p;
  }
}
