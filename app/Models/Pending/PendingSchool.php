<?php

namespace App\Models\Pending;

use Illuminate\Database\Eloquent\Model;

class PendingSchool extends PendingBase
{
    protected $table = 'pending_schools';

    public function school()
    {
        return $this->belongsTo('App\Models\School\School', 'school_id', 'id');
    }

    public function zip()
    {
        return $this->belongsTo('App\Models\Zip\Zip', 'zip_id', 'id');
    }

    public function pending_classes()
    {
      return $this->hasMany('App\Models\Pending\PendingClass', 'pending_school_id', 'id');
    }

    public function pending_subjects()
    {
      return $this->hasMany('App\Models\Pending\PendingSchoolSubject', 'pending_school_id', 'id');
    }


}
