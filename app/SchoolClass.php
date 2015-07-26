<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
  protected $table = 'classes';

  public function class_levels()
  {
      return $this->hasMany('App\Level', 'class_id', 'id');

  }

}
