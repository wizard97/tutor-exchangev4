<?php
namespace App\Models\Proposal;

use Illuminate\Database\Eloquent\Model;
use ProposalType;


abstract class BaseProposal extends Model
{
    public $timestamps = false;

    // The thig being proposed
    protected $proposing= "None";



    public function getProposalName()
    {
        return $this->proposing;
    }

    public function getProposalType()
    {
        return $this->proposal->type;
    }


    public function proposal()
    {
        /*
        return $this
            ->belongsTo('App\Models\Proposal\Proposal', 'proposal_id', 'id')
            ->where('proposals.proposable_type', $this->getMorphClass());
            */
        //return $this->belongsTo('App\Models\Proposal\Proposal', 'proposal_id', 'id');
        return $this->morphOne("App\Models\Proposal\Proposal", "proposable");
    }

}
