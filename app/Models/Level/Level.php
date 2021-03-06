<?php

namespace App\Models\Level;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
  protected $table = 'levels';
  protected $fillable = ['level_num', 'level_name'];

  public function school_class()
  {
    return $this->belongsTo('App\Models\SchoolClass\SchoolClass', 'class_id', 'id');
  }

  public function tutors()
  {
    return $this->belongsToMany('App\Models\Tutor\Tutor', 'tutor_levels', 'level_id', 'user_id')->withTimestamps();
  }

  public function pending_levels()
  {
    return $this->hasMany('App\Models\Pending\PendingLevel', 'level_id', 'id');
  }

  //return ids of matches
  public function scopeFindTutors($query)
  {
    //get the classes and levels, and join that on the tutor_levels table
  return $query
  ->join('tutor_levels', 'levels.id', '=', 'tutor_levels.level_id')
  ->join('users', 'users.id', '=', 'tutor_levels.user_id')
  ->join('tutors', 'tutors.user_id', '=', 'tutor_levels.user_id')
  ->where('account_type', '>=', '2')
  ->where('tutors.tutor_active', '=', '1')
  ->where('tutors.profile_expiration', '>=', date('Y-m-d H:i:s'))
  ->select(\DB::raw('count(*) as class_matches, tutor_levels.user_id, users.account_type'))
  ->groupBy('tutor_levels.user_id')->orderBy('class_matches', 'desc')->orderBy('lname', 'asc');
  }

}
