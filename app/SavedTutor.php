<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SavedTutor extends Model
{
  protected $table = 'saved_tutors';

  public function user()
  {
    return $this->belongsTo('App\User', 'user_id', 'id');
  }

  public function tutor()
  {
    return $this->belongsTo('App\Tutor', 'tutor_id', 'user_id');
  }
}
