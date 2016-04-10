<?php
namespace App\Repositories\Proposals\School;

use App\Repositories\BaseRepository;

use App\Models\Proposal\PendingSchool;

use App\Repositories\Proposals\Proposal\ProposalRepository;
use App\Repositories\Proposals\Status\StatusRepository;
use App\Repositories\School\SchoolRepository;
use App\Repositories\Zip\ZipRepository;

class SchoolProposalRepository extends BaseRepository implements SchoolProposalRepositoryContract
{

  public function __construct(PendingSchool $model,
      ProposalRepository $proposalRepository,
      SchoolRepository $schoolRepository,
      ZipRepository $zipRepository,
      StatusRepository $statusRepository)
  {
    $this->model = $model;
    $this->proposalRepository = $proposalRepository;
    $this->schoolRepository = $schoolRepository;
    $this->zipRepository = $zipRepository;
    $this->statusRepository = $statusRepository;
  }

  public function create($inputs, $user_id)
  {
    $type = $inputs['proposal_type'];
    $ps = new $this->model;

    if ($type == 'create' || $type == 'edit')
    {
      // If edit associate with model
      if ($type == 'edit')
      {
        $scl = $this->schoolRepository->findBySearch($inputs['school_search'])->first();
        $ps->school()->associate($scl);
      }
      $g = \Geocoder::geocode($inputs['address']);
      $address = sprintf("%s %s, %s, %s %s", $g->getStreetNumber(), $g->getStreetName(),
          $g->getCity(), $g->getRegionCode(), $g->getZipCode());

      $ps->address = $address;
      $zip = $this->zipRepository->findBySearch($g->getCity().', '.$g->getRegionCode().', '.$g->getZipCode())->first();
      $ps->zip()->associate($zip);
      $ps->lat = $g->getLatitude();
      $ps->lon = $g->getLongitude();
      $ps->school_name = $inputs['school_name'];
      $ps->to_delete = false;

    }
    else if ($type == 'delete')
    {
      $scl = $this->schoolRepository->findBySearch($inputs['school_search'])->first();
      $ps->school()->associate($scl);

      $ps->school_name = $scl->school_name;
      $ps->zip_id = $scl->zip_id;
      $ps->address = $scl->address;
      $ps->lat = $scl->lat;
      $ps->lon = $scl->lon;
      $ps->to_delete = true;
    }

    // Make sure no existing proposalas
    if ($type != 'create')
    {
      //Eventually make a custom exception
      if (!$this->getProposalsBySchool($ps->school_id)->isEmpty())
          throw new \Exception("Existing pending proposal");
    }


    $prop = $this->proposalRepository->create($user_id);
    $prop->pending_school()->save($ps);

    return $prop->with('pending_school');
  }

  public function getProposalsBySchool($school_id, $pending_only = true)
  {
    $query = $this->model
        ->join('proposals', 'proposals.id', '=', 'pending_schools.proposal_id')
        ->where('school_id', '=', $school_id);

    if ($pending_only)
    {
      $query->where('proposals.status_id', '=', $this->statusRepository->findBySlug('pend_acpt')->id);
    }

    return $query->get();
  }
}
