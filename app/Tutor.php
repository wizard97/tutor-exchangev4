<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tutor extends Model
{
    public function user()
    {
      return $this->belongsTo('App\User', 'user_id', 'id');
    }



    public function classes()
    {
      return $this->hasMany('App\TutorLevel', 'user_id', 'user_id');
    }

    public function scopeTutorInfo($query, $user_ids)
    {
      return $query->join('users', 'users.id', '=', 'tutors.user_id')
      ->whereIn('id', $user_ids)
      ->select('tutors.*', 'users.*');
    }

}
