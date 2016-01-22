<?php

namespace App\Models\School;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
  protected $fillable = ['school_name'];

  public function tutors()
  {
      return $this->belongsToMany('App\Models\Tutor\Tutor', 'tutor_schools', 'school_id', 'tutor_id')->withTimestamps();
  }

  public function zip()
  {
      return $this->belongsTo('App\Models\Zip\Zip', 'zip_id', 'id');
  }

  public function classes()
  {
    return $this->hasManyThrough('App\Models\SchoolClass\SchoolClass', 'App\Models\SchoolSubject\SchoolSubject', 'school_id', 'subject_id');
    //return $this->hasMany('App\SchoolClass', 'school_id', 'id');
  }

  public function subjects()
  {
    return $this->hasMany('App\Models\SchoolSubject\SchoolSubject', 'school_id', 'id');
  }

  public function school_proposals()
  {
    return $this->hasMany('App\Models\Pending\PendingSchool', 'school_id', 'id');
  }
}
