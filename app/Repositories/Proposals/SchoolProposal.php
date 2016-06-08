<?php
namespace App\Repositories\Proposals;
use App\Models\Proposal\Proposal;
use App\Models\Proposal\SchoolProposal;
use App\Models\Proposal\Status;
use App\Models\School\School;
use App\Models\Zip\Zip;
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

    public function __construct(Proposal $prop, Status $status, Zip $zip, SchoolProposal $pendSchool, School $school)
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
            $this->model->to_delete = true;
        }
        else {
            $this->model->school_name = $input['school_name'];
            $this->model->zip_id = $this->zip->findOrFail($input['zip_id'])->id;
            $this->model->to_delete = false;
        }
    }

    public function validate()
    {
        // Make sure school_id is set if edit
        if ($this->getType() === ProposalType::EDIT || $this->getType() === ProposalType::DELETE)
        {
            // Are there any pending edits?
            $sid = $this->status->getStatusId("pend_acpt");
            $qry = $this->pend_school->where("school_id", $sid)->has('proposal');

            if ($qry->get()->count() !== 0)
                throw new ProposalException('There are existing pending edits for school.');


            if (is_null($this->model->school()->first()))
                throw new ProposalException('Trying to edit an unknown school.');
        }

        if (is_null($this->model->school_name))
            throw new ProposalException('All the fields must be filled out.');

        if (is_null($this->model->zip))
            throw new ProposalException('Unknown town/city.');

    }



}
