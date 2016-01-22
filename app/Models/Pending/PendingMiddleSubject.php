<?php

namespace App\Models\Pending;

use Illuminate\Database\Eloquent\Model;

class PendingMiddleSubject extends PendingBase
{
    protected $table = 'pending_middle_subjects';

    public function middle_subject()
    {
        return $this->belongsTo('App\Models\MiddleSubject\\MiddleSubject', 'middle_subject_id', 'id');
    }

    public function pending_classes()
    {
        return $this->hasMany('App\Models\Pending\PendingMiddleClass', 'pending_middle_subject_id', 'id');
    }

}
