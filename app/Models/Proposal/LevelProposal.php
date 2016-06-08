<?php

namespace App\Models\Proposal;

use Illuminate\Database\Eloquent\Model;

class LevelProposal extends BaseProposal
{
    protected $table = 'level_proposals';

    protected $proposing = "Level Proposal";

    // Replacing
    public function level()
    {
        return $this->belongsTo('App\Models\Level\Level', 'level_id', 'id');
    }

    // popsed class
    public function class()
    {
      return $this->belongsTo('App\Models\SchoolClass\SchoolClass', 'class_id', 'id');
    }
/*
    public function school_class_proposal()
    {
      return $this->belongsTo('App\Models\Proposal\ClassProposal', 'class_proposal_id', 'id');
    }
    */

}
