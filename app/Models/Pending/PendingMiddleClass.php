<?php

namespace App\Models\Pending;

use Illuminate\Database\Eloquent\Model;

class PendingMiddleClass extends PendingBase
{
    protected $table = 'pending_middle_classes';

    public function middle_class()
    {
        return $this->belongsTo('App\MiddleClass', 'middle_class_id', 'id');
    }

    public function subject()
    {
      return $this->belongsTo('App\MiddleSubject', 'middle_subject_id', 'id');
    }

    public function pending_subject()
    {
      return $this->belongsTo('App\Models\Pending\PendingMiddleSubject', 'pending_middle_subject_id', 'id');
    }

}
