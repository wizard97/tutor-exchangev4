<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
  public function class_info()
  {
    return $this->belongsTo('App\SchoolClass', 'class_id', 'id');
  }

  public function tutors_with_levels()
  {
    return $this->hasMany('App\TutorLevel', 'level_id', 'id');
  }

}
