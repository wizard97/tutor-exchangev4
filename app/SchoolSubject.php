<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolSubject extends Model
{
  protected $table = 'school_subjects';

  protected $fillable = ['subject_name'];

  public function school()
  {
      return $this->belongsTo('App\School', 'school_id', 'id');
  }

  public function classes()
  {
      return $this->hasMany('App\SchoolClass', 'subject_id', 'id');
  }
}
