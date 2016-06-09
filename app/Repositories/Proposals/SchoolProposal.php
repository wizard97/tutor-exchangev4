<?php
namespace App\Repositories\Proposals;
use App\Models\Proposal\Proposal;
use App\Models\Proposal\SchoolProposal;
use App\Models\Proposal\Status;
use App\Models\School\School;
use App\Repositories\Zip\ZipRepository;
use App\Models\Proposal\ProposalType;
use App\Exceptions\ProposalException;
/*
Must impliment the following:
protected abstract function createProposable($input);
public abstract function validate(); // throws ProposalException
public abstract function parent(); // throws ProposalException
public abstract function children(); // throws ProposalException
public abstract function getType();
*/

class SchoolProposal extends BaseProposal implements ProposalContract
{

    public function __construct(Proposal $prop, Status $status, ZipRepository $zip, SchoolProposal $pendSchool, School $school)
    {
        Parent::__construct($prop, $status);
        $this->zip = $zip;
        $this->pend_school = $pendSchool;
        $this->schl = $school;
        $this->model = new $this->pend_school;
    }

    public function parent()
    {
        return NULL;
    }

    public function children()
    {
        // TODO:
        return array();
    }

    public function getType()
    {
        if ($this->model->to_delete)
            return ProposalType::DELETE;
        else if (!is_null($this->model->school_id))
            return ProposalType::EDIT;
        else
            return ProposalType::ADD;
    }

    protected function createProposable($input)
    {
        $this->model = new $this->pend_school;

        if (!is_null($input['school_id'])) $this->model->school_id = $input['school_id'];

        if ($input['to_delete'])
        {
            $scl = $this->schl->findOrFail($input['school_id']);
            $this->model->school_name = $scl->school_name;
            $this->model->zip_id = $scl->zip_id;
            $this->model->address = $scl->address;
            $this->model->lat = $scl->lat;
            $this->model->lon = $scl->lon;
            $this->model->to_delete = true;
        }
        else {
            $this->model->school_name = $input['school_name'];
            $this->model->zip_id = NULL;
            $this->model->address = $input['address'];
            $this->model->to_delete = false;
        }
        return true;
    }

    protected function acceptProposal()
    {
        if ($this->getType() == ProposalType::DELETE) {
            $this->model->school->delete();
            return true;
        } else if ($this->getType() == ProposalType::EDIT || $this->getType() == ProposalType::ADD) {

            if ($this->getType() == ProposalType::EDIT)
                $s = $this->model->school;
            else
                $s = new $this->scl;

            // Copy over the changes
            $s->school_name = $this->model->school_name;
            $s->zip_id = $this->model->zip_id;
            $s->address = $this->model->address;
            $s->lon = $this->model->lon;
            $s->lat = $this->model->lat;
            $s->save();
            return $s;
        }
    }

    public function validate()
    {
        // Make sure school_id is set if edit
        if ($this->getType() == ProposalType::EDIT || $this->getType() == ProposalType::DELETE)
        {
            // Are there any pending edits?
            $sid = $this->status->getStatusId("pend_acpt");
            $qry = $this->pend_school->where("school_id", $sid)->has('proposal');

            if ($qry->get()->count() !== 0)
                throw new ProposalException('There are existing pending edits for school.');


            if (is_null($this->model->school()->first()))
                throw new ProposalException('Trying to edit an unknown school.');
        }

        if ($this->getType() == ProposalType::EDIT || $this->getType() == ProposalType::ADD)
        {
            try {
                $g = \Geocoder::geocode($this->model->address);
                $this->model->address = sprintf("%d %s, %s, %s %s, %s",
                    $g->getStreetNumber(), $g->getStreetName(), $g->getCity(),
                    $g->getRegionCode(), $g->getZipcode(), $g->getCountryCode());
                $this->model->lat = $g->getLatitude();
                $this->model->lon = $g->getLongitude();
                $this->model->zip()->associate($this->zip->find($g->getZipcode(), $g->getCity()));
            } catch (\Exception $e) {
                // Here we will get "The FreeGeoIpProvider does not support Street addresses." ;)
                throw new ProposalException('Unable to resolve address field');
            }
        }

        if (is_null($this->model->school_name))
            throw new ProposalException('All the fields must be filled out.');

        if (is_null($this->model->zip))
            throw new ProposalException('Unknown town/city.');

        return true;
    }

}
