<?php

namespace App\Models\Proposal;

use Illuminate\Database\Eloquent\Model;

class MiddleClassProposal extends BaseProposal
{
    protected $table = 'middle_class_proposals';

    protected $proposalType = "Middle School Class Proposal";

    public function middle_class()
    {
        return $this->belongsTo('App\Models\MiddleClass\MiddleClass', 'middle_class_id', 'id');
    }

    public function subject()
    {
      return $this->belongsTo('App\Models\MiddleSubject\MiddleSubject', 'middle_subject_id', 'id');
    }

    public function subject_proposal()
    {
      return $this->belongsTo('App\Models\Proposal\MiddleSubjectProposal', 'middle_subject_proposal_id', 'id');
    }

}
