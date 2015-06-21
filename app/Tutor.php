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
}
