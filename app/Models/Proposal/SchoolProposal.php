<?php

namespace App\Models\Proposal;

use Illuminate\Database\Eloquent\Model;

class SchoolProposal extends BaseProposal
{
    protected $table = 'school_proposals';

    protected $proposalType = "School Proposal";

    // Replacing
    public function school()
    {
        return $this->belongsTo('App\Models\School\School', 'school_id', 'id');
    }

    public function zip()
    {
        return $this->belongsTo('App\Models\Zip\Zip', 'zip_id', 'id');
    }

    public function class_proposals()
    {
      return $this->hasMany('App\Models\Proposal\PendingClass', 'school_proposal_id', 'id');
    }

    public function pending_subjects()
    {
      return $this->hasMany('App\Models\Proposal\SchoolSubjectProposal', 'school_proposal_id', 'id');
    }


}
