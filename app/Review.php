<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
  protected $table = 'reviews';

  protected $fillable = ['tutor_id', 'rating' ,'title', 'message', 'anonymous'];

  public function user()
  {
    return $this->belongsTo('App\User', 'reviewer_id', 'id');
  }

  public function tutor()
  {
    return $this->belongsTo('App\Tutor', 'tutor_id', 'user_id');
  }
}
