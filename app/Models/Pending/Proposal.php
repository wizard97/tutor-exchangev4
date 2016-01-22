<?php

namespace App\Models\Pending;

use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    protected $table = 'proposals';

    public function user()
    {
      return $this->belongsTo('App\Models\User\User', 'user_id', 'id');
    }

    public function status()
    {
    return $this->belongsTo('App\Models\Pending\Status', 'status_id', 'id');
    }

    public function pending_school()
    {
        return $this->hasOne('App\Models\Pending\PendingSchool', 'proposal_id', 'id');
    }

    public function pending_school_subject()
    {
        return $this->hasOne('App\Models\Pending\PendingSchoolSubject', 'proposal_id', 'id');
    }

    public function pending_class()
    {
        return $this->hasOne('App\Models\Pending\PendingClass', 'proposal_id', 'id');
    }

    public function pending_level()
    {
        return $this->hasOne('App\Models\Pending\PendingLevel', 'proposal_id', 'id');
    }


    public function pending_middle_class()
    {
        return $this->hasOne('App\Models\Pending\PendingMiddleClass', 'proposal_id', 'id');
    }

    public function pending_middle_subject()
    {
        return $this->hasOne('App\Models\Pending\PendingMiddleSubject', 'proposal_id', 'id');
    }

    public function pending_music()
    {
        return $this->hasOne('App\Models\Pending\PendingMusic', 'proposal_id', 'id');
    }
}
