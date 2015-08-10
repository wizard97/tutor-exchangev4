<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
  protected $table = 'classes';

  protected $fillable = ['class_name', 'school_id'];

  public function levels()
  {
      return $this->hasMany('App\Level', 'class_id', 'id');
  }

  public function school()
  {
      return $this->belongsTo('App\School', 'school_id', 'id');
  }

}
