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

    public function reviews()
    {
      return $this->hasMany('App\Review', 'tutor_id', 'user_id')
      ->join('users', 'users.id', '=', 'reviews.reviewer_id');

    }

    public function scopeTutorInfo($query, $user_ids)
    {
      return $query->join('users', 'users.id', '=', 'tutors.user_id')
      ->whereIn('id', $user_ids)
      ->select('tutors.*', 'users.*');
    }

    //passed by refrence to advoid excessive copying
    static public function add_classes_reviews(&$tutor_array, $selected, $id_counts)
    {
      foreach($tutor_array as $tutor)
      {
        $id = $tutor->user_id;
        //add match %
        if ($selected < 1) $percent_match = 100;
        else $percent_match = number_format(($id_counts[$id]['class_matches']/$selected)*100, 0);
        $tutor->percent_match = $percent_match;

        //add reviews
        $user_reviews = \App\Tutor::where('user_id', $id)->firstOrFail()->reviews();
        $tutor->num_reviews = $user_reviews->count();
        $tutor->all_reviews = $user_reviews->get();
        //round rating to 1 decimal place
        if ($tutor->num_reviews != 0) $tutor->rating = round($user_reviews->avg('rating'), 1);
        else $tutor->rating = 0;

        $tutor->star_count = floor($tutor->rating);
        $rating_decimal = $tutor->rating - floor($tutor->rating);

        if ($rating_decimal <= 0.2) $tutor->half_star = false;
        elseif ($rating_decimal <= 0.7) $tutor->half_star = true;
        else
        {
          $tutor->half_star = false;
          $tutor->star_count++;
        }

        $tutor->empty_stars = 5 - $tutor->star_count;
        if ($tutor->half_star) $tutor->empty_stars--;
      }

    }
}
