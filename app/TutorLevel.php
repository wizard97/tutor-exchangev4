<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TutorLevel extends Model
{
  protected $guarded = ['user_id'];
  protected $table = 'tutor_levels';
  public function level()
  {
    return $this->belongsTo('App\Level', 'level_id', 'id');
  }



}
