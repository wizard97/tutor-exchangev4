<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TutorContact extends Model
{

protected $primaryKey = 'id';
protected $table = 'tutor_contacts';

public function user()
{
  return $this->belongsTo('App\User', 'user_id', 'id');
}


public function tutor()
{
  return $this->belongsTo('App\Tutor', 'tutor_id', 'user_id');
}


}
