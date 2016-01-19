<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
  protected $fillable = ['school_name'];

  public function tutors()
  {
      return $this->belongsToMany('App\Tutor', 'tutor_schools', 'school_id', 'tutor_id')->withTimestamps();
  }

  public function zip()
  {
      return $this->belongsTo('App\Zip', 'zip_id', 'id');
  }

  public function classes()
  {
    return $this->hasManyThrough('App\SchoolClass', 'App\SchoolSubject', 'school_id', 'subject_id');
    //return $this->hasMany('App\SchoolClass', 'school_id', 'id');
  }

  public function subjects()
  {
    return $this->hasMany('App\SchoolSubject', 'school_id', 'id');
  }
}
