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

  //return ids of matches
  public function scopeFindTutors($query)
  {
    //get the classes and levels, and join that on the tutor_levels table
  return $query
  ->join('tutor_levels', 'levels.id', '=', 'tutor_levels.level_id')
  ->join('tutors', 'tutors.user_id', '=', 'tutor_levels.user_id')
  ->select(\DB::raw('count(*) as class_matches, tutor_levels.user_id'))
  ->groupBy('tutor_levels.user_id')->orderBy('class_matches', 'desc');
  }

}
