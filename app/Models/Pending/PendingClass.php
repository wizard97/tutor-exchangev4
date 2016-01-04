<?php

namespace App\Models\Pending;

use Illuminate\Database\Eloquent\Model;

class PendingClass extends PendingBase
{
    protected $table = 'pending_classes';

    public function school_class()
    {
        return $this->belongsTo('App\SchoolClass', 'class_id', 'id');
    }

    public function pending_levels()
    {
        return $this->hasMany('App\Models\Pending\PendingLevel', 'pending_class_id', 'id');
    }

    public function school()
    {
        return $this->belongsTo('App\School', 'school_id', 'id');
    }

    public function pending_school()
    {
        return $this->belongsTo('App\Models\Pending\PendingSchool', 'pending_school_id', 'id');
    }

    public function subject()
    {
        return $this->belongsTo('App\SchoolSubject', 'subject_id', 'id');
    }

    public function pending_subject()
    {
        return $this->belongsTo('App\Models\Pending\PendingSchoolSubject', 'pending_subject_id', 'id');
    }

}
