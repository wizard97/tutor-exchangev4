<?php

namespace App\Models\Proposal;

use Illuminate\Database\Eloquent\Model;

class SchoolSubjectProposal extends BaseProposal
{
    protected $table = 'school_subject_proposalss';

    protected $proposalType = "School Subject Proposal";

    // Replacing
    public function school_subject()
    {
        return $this->belongsTo('App\Models\SchoolSubject\SchoolSubject', 'school_subject_id', 'id');
    }

    public function school()
    {
        return $this->belongsTo('App\Models\School\School', 'school_id', 'id');
    }

    public function pending_school()
    {
        return $this->belongsTo('App\Models\Proposal\SchoolProposal', 'school_proposal_id', 'id');
    }

    public function class_proposals()
    {
        return $this->hasMany('App\Models\Proposal\PendingClass', 'class_proposal_id', 'id');
    }


}
