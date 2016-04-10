<?php
namespace App\Models\Proposal;

use Illuminate\Database\Eloquent\Model;

abstract class BaseProposal extends Model
{
    public $timestamps = false;

    protected $proposalType = "";

    public function getProposalType()
    {
        return $proposalType;
    }

    public function proposal()
    {
        return $this
            ->belongsTo('App\Models\Proposal\Proposal', 'proposal_id', 'id')
            ->where('proposals.proposable_type', $this->getMorphClass());
        //return $this->belongsTo('App\Models\Proposal\Proposal', 'proposal_id', 'id');
    }

}
