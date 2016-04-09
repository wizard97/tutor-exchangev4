<?php

namespace App\Models\Proposal;

use Illuminate\Database\Eloquent\Model;

class ClassProposal extends BaseProposal
{
    protected $table = 'class_proposals';

    public function school_class()
    {
        return $this->belongsTo('App\Models\SchoolClass\SchoolClass', 'class_id', 'id');
    }

    public function level_proposals()
    {
        return $this->hasMany('App\Models\Proposal\LevelProposal', 'class_proposal_id', 'id');
    }

    public function school()
    {
        return $this->belongsTo('App\Models\School\School', 'school_id', 'id');
    }

    public function school_proposal()
    {
        return $this->belongsTo('App\Models\Proposal\SchoolProposal', 'school_proposal_id', 'id');
    }

    public function subject()
    {
        return $this->belongsTo('App\Models\SchoolSubject\SchoolSubject', 'subject_id', 'id');
    }

    public function subject_proposal()
    {
        return $this->belongsTo('App\Models\Proposal\SchoolSubjectProposal', 'subject_proposal_id', 'id');
    }

}
