<?php
namespace App\Repositories\Proposals\Proposal;

use App\Repositories\BaseRepository;
use App\Models\Proposal\ProposalType;
use App\Models\Proposal\BaseProposal;
use App\Repositories\Proposals\Status\StatusRepository;

class ProposalRepository extends BaseRepository implements ProposalRepositoryContract
{

  public function __construct(Proposal $model, StatusRepository $statusRepository)
  {

    $this->model = $model;
    $this->statusRepository = $statusRepository;
  }

  public function getUsersProposals(int $user_id, $per_page = 15)
  {
      return $this->model->where('user_id', $user_id)->paginate($per_page);
  }


  public function updateOrCreate(BaseProposal $proposable, int $user_id, $title, ProposalType $type)
  {
    $status = $this->statusRepository->findBySlug('pend_acpt');
    $p = $proposable->proposal()->
        updateOrCreate(['user_id' => $user_id, 'title' => $title,
            'status' => $status->id, 'type' => $type]);
    return $p;
  }
}
