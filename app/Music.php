<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Music extends Model
{
  protected $table = 'music';
  protected $fillable = ['music_name'];

  public function tutors()
  {
    return $this->belongsToMany('App\Tutor', 'tutor_music', 'music_id', 'tutor_id')->withTimestamps()->withPivot('upto_years', 'years_experiance');
  }
}
