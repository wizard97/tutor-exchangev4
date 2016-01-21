<?php

namespace App\Models\MiddleClass;

use Illuminate\Database\Eloquent\Model;

class MiddleClass extends Model
{
    protected $table = 'middle_classes';
    protected $fillable = ['class_name'];

    public function subject()
    {
      return $this->belongsTo('App\Models\MiddleSubject\MiddleSubject', 'middle_subject_id', 'id');
    }

    public function tutor()
    {
      return $this->belongsToMany('App\Models\Tutor\Tutor', 'tutor_middle_classes', 'middle_classes_id', 'tutor_id')->withTimestamps();
    }
}
