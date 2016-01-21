<?php

namespace App\Models\SchoolSubject;

use Illuminate\Database\Eloquent\Model;

class SchoolSubject extends Model
{
  protected $table = 'school_subjects';

  protected $fillable = ['subject_name'];

  public function school()
  {
      return $this->belongsTo('App\Models\School\School', 'school_id', 'id');
  }

  public function classes()
  {
      return $this->hasMany('App\Models\SchoolClass\SchoolClass', 'subject_id', 'id');
  }
}
