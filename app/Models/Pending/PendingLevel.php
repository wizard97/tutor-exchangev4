<?php

namespace App\Models\Pending;

use Illuminate\Database\Eloquent\Model;

class PendingLevel extends PendingBase
{
    protected $table = 'pending_levels';

    public function level()
    {
        return $this->belongsTo('App\Level', 'level_id', 'id');
    }

    public function school_class()
    {
      return $this->belongsTo('App\SchoolClass', 'class_id', 'id');
    }

    public function pending_school_class()
    {
      return $this->belongsTo('App\Models\Pending\PendingClass', 'pending_class_id', 'id');
    }

}
