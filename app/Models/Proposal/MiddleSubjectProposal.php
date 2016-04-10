<?php

namespace App\Models\Proposal;

use Illuminate\Database\Eloquent\Model;

class MiddleSubjectProposal extends BaseProposal
{
    protected $table = 'middle_subject_proposals';

    protected $proposalType = "Middle School Subject Proposal";

    public function middle_subject()
    {
        return $this->belongsTo('App\Models\MiddleSubject\MiddleSubject', 'middle_subject_id', 'id');
    }

    public function class_proposals()
    {
        return $this->hasMany('App\Models\Proposal\MiddleClassProposal', 'middle_subject_proposal_id', 'id');
    }

}
