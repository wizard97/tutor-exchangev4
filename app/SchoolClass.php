<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
  protected $table = 'classes';

  public function levels()
  {
      return $this->hasMany('App\Level', 'class_id', 'id');

  }

  public function school()
  {
      return $this->belongsTo('App\School', 'school_id', 'id');
  }

}
