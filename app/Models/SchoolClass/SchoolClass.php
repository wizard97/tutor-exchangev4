<?php

namespace App\Models\SchoolClass;

use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
  protected $table = 'classes';

  protected $fillable = ['class_name', 'school_id'];

  public function levels()
  {
      return $this->hasMany('App\Models\Level\Level', 'class_id', 'id');
  }

  public function school()
  {
      return $this->subject->school;
  }

  public function subject()
  {
      return $this->belongsTo('App\Models\SchoolSubject\SchoolSubject', 'subject_id', 'id');
  }

}
