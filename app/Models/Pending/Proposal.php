<?php

namespace App\Models\Pending;

use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    protected $table = 'proposals';

    public function status()
    {
    return $this->belongsTo('App\Models\Pending\Status', 'status_id', 'id');
    }

    public function pending_schools()
    {
        return $this->hasMany('App\Models\Pending\PendingSchool', 'proposal_id', 'id');
    }

    public function pending_school_subjects()
    {
        return $this->hasMany('App\Models\Pending\PendingSchoolSubject', 'proposal_id', 'id');
    }

    public function pending_classes()
    {
        return $this->hasMany('App\Models\Pending\PendingClass', 'proposal_id', 'id');
    }

    public function pending_levels()
    {
        return $this->hasMany('App\Models\Pending\PendingLevel', 'proposal_id', 'id');
    }


    public function pending_middle_classes()
    {
        return $this->hasMany('App\Models\Pending\PendingMiddleClass', 'proposal_id', 'id');
    }

    public function pending_middle_subjects()
    {
        return $this->hasMany('App\Models\Pending\PendingMiddleSubject', 'proposal_id', 'id');
    }

    public function pending_music()
    {
        return $this->hasMany('App\Models\Pending\PendingMusic', 'proposal_id', 'id');
    }
}
