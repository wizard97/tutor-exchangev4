<?php

namespace App\Models\Proposal;

use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    protected $table = 'proposals';

    public function proposable()
    {
        return $this->hasMany($this->proposable_type, 'proposal_id', 'id');
    }

    public function getProposalType()
    {
        return $this->proposable()->first()->getProposalType();
    }


    public function user()
    {
      return $this->belongsTo('App\Models\User\User', 'user_id', 'id');
    }

    public function status()
    {
    return $this->belongsTo('App\Models\Proposal\Status', 'status_id', 'id');
    }
/*
    /////////////// POLYMORPHIC RELATIONSHIPS FOR PROPOSALS /////////////
    public function school_proposal()
    {
        return $this->morphedByMany('App\Models\Proposal\SchoolProposal', 'proposable');
        //return $this->hasOne('App\Models\Pending\PendingSchool', 'proposal_id', 'id');
    }

    public function school_subject_proposal()
    {
        return $this->morphedByMany('App\Models\Proposal\SchoolSubjectProposal', 'proposable');
        //return $this->hasOne('App\Models\Pending\PendingSchoolSubject', 'proposal_id', 'id');
    }

    public function class_proposal()
    {
        return $this->morphedByMany('App\Models\Proposal\ClassProposal', 'proposable');
        //return $this->hasOne('App\Models\Pending\PendingClass', 'proposal_id', 'id');
    }

    public function level_proposals()
    {
        return $this->morphedByMany('App\Models\Proposal\LevelProposal', 'proposable');
        //return $this->hasOne('App\Models\Pending\PendingLevel', 'proposal_id', 'id');
    }


    public function middle_class_proposal()
    {
        return $this->morphedByMany('App\Models\Proposal\MiddleClassProposal', 'proposable');
        //return $this->hasOne('App\Models\Pending\PendingMiddleClass', 'proposal_id', 'id');
    }

    public function middle_subject_proposal()
    {
        return $this->morphedByMany('App\Models\Proposal\MiddleSubjectProposal', 'proposable');
        //return $this->hasOne('App\Models\Pending\PendingMiddleSubject', 'proposal_id', 'id');
    }

    public function music_proposal()
    {
        return $this->morphedByMany('App\Models\Proposal\MusicProposal', 'proposable');
        //return $this->hasOne('App\Models\Pending\PendingMusic', 'proposal_id', 'id');
    }
    */
}
