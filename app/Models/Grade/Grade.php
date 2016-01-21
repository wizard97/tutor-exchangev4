<?php

namespace App\Models\Grade;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
  public function pending_levels()
  {
    return $this->hasMany('App\Models\Tutor\Tutor', 'grade_id', 'id');
  }

}
