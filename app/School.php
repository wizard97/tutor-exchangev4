<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
  public function tutors()
  {
      return $this->belongsToMany('App\Tutor', 'tutor_schools', 'school_id', 'tutor_id');
  }

  public function zip()
  {
      return $this->belongsTo('App\Zip', 'zip_code', 'zip_code');
  }

  public function classes()
  {
    return $this->hasMany('App\SchoolClass', 'school_id', 'id');
  }
}
