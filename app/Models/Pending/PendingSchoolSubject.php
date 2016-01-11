<?php

namespace App\Models\Pending;

use Illuminate\Database\Eloquent\Model;

class PendingSchoolSubject extends PendingBase
{
    protected $table = 'pending_school_subjects';

    public function school_subject()
    {
        return $this->belongsTo('App\SchoolSubject', 'school_subject_id', 'id');
    }

    public function school()
    {
        return $this->belongsTo('App\School', 'school_id', 'id');
    }

    public function pending_school()
    {
        return $this->belongsTo('App\Models\Pending\PendingSchool', 'pending_school_id', 'id');
    }

    public function pending_classes()
    {
        return $this->hasMany('App\Models\Pending\PendingClass', 'pending_subject_id', 'id');
    }


}
