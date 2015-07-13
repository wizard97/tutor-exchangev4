<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TutorContact extends Model
{

protected $primaryKey = 'id';
protected $table = 'tutor_contacts';

public function contacter()
{
  return $this->belongsTo('App\User', 'user_id', 'id');
}


}
