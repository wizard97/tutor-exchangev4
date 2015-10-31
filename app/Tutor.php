<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tutor extends Model
{
  protected $primaryKey = 'user_id';

    public function user()
    {
      return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function levels()
    {
      return $this->belongsToMany('App\Level', 'tutor_levels', 'user_id', 'level_id')->withTimestamps();
    }

    public function music()
    {
      return $this->belongsToMany('App\Music', 'tutor_music', 'tutor_id', 'music_id')->withTimestamps()->withPivot('upto_years', 'years_experiance');
    }

    //middle school classes and below
    public function middle_classes()
    {
      return $this->belongsToMany('App\MiddleClass', 'tutor_middle_classes', 'tutor_id', 'middle_classes_id')->withTimestamps();
    }

    public function reviews()
    {
      return $this->hasMany('App\Review', 'tutor_id', 'user_id');

    }

    public function schools()
    {
        return $this->belongsToMany('App\School', 'tutor_schools', 'tutor_id', 'school_id')->withTimestamps();
    }

    public function contacts()
    {
      return $this->hasMany('App\TutorContact', 'tutor_id', 'user_id');
    }

    public function scopeTutorInfo($query, $user_ids)
    {
      return $query->join('users', 'users.id', '=', 'tutors.user_id')
      ->leftjoin('grades', 'tutors.grade', '=', 'grades.id')
      ->whereIn('users.id', $user_ids);
    }


    static public function add_classes_reviews($tutor_info, $selected = 0, $id_counts = [])
    {
      //this is deprecated, remove when possible
      /*
      $tutor_full = $tutor_info;

      foreach($tutor_full as $tutor)
      {
        $id = $tutor->user_id;
        //add match %
        if ($selected < 1) $percent_match = 100;
        else $percent_match = number_format(($id_counts[$id]['class_matches']/$selected)*100, 0);
        $tutor->percent_match = $percent_match;

        //add reviews
        $user_reviews = \App\Tutor::where('user_id', $id)->firstOrFail()->reviews()->orderBy('reviews.created_at', 'desc');
        $tutor->num_reviews = $user_reviews->count();

        $tutor->all_reviews = $user_reviews->paginate(15);
        //round rating to 1 decimal place
        if ($tutor->num_reviews != 0) $tutor->rating = round(\App\Tutor::where('user_id', $id)->firstOrFail()->reviews()->avg('rating'), 1);
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

        //get classes
        $classes = \App\Tutor::findOrFail($id)->levels()
            ->join('classes', 'levels.class_id', '=', 'classes.id')->get()->groupBy('class_type');

        //collections suck, key it by class_id
        $tutor_classes = array();
        foreach($classes as $subject => $subject_array)
        {
          $tutor_classes[$subject] = array();
          foreach($subject_array as $class)
          {
            $tutor_classes[$subject][$class->class_id] = $class;
          }
        }
        $tutor->tutor_classes = $tutor_classes;
      }
      return $tutor_full;
      */
      return;
    }

    static public function insert_classes_reviews($tutor_info)
    {
      //deprecated remove when possible
      /*
      $tutor_full = $tutor_info;

      foreach($tutor_full as $tutor)
      {
        $id = $tutor->user_id;

        //add reviews
        $user_reviews = \App\Tutor::where('user_id', $id)->firstOrFail()->reviews()->orderBy('reviews.created_at', 'desc');
        $tutor->num_reviews = $user_reviews->count();

        $tutor->all_reviews = $user_reviews->paginate(15);
        //round rating to 1 decimal place
        if ($tutor->num_reviews != 0) $tutor->rating = round(\App\Tutor::where('user_id', $id)->firstOrFail()->reviews()->avg('rating'), 1);
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

        //get classes
        $classes = \App\Tutor::findOrFail($id)->classes()->join('levels', 'tutor_levels.level_id', '=', 'levels.id')
            ->join('classes', 'levels.class_id', '=', 'classes.id')->orderBy('class_order', 'asc')->get()->groupBy('class_type');

        //collections suck, key it by class_id
        $tutor_classes = array();
        foreach($classes as $subject => $subject_array)
        {
          $tutor_classes[$subject] = array();
          foreach($subject_array as $class)
          {
            $tutor_classes[$subject][$class->class_id] = $class;
          }
        }
        $tutor->tutor_classes = $tutor_classes;
      }
      return $tutor_full;
      */
    }

    static public function get_tutor_profile($id)
    {
      $tutor = \App\Tutor::join('users', 'users.id', '=', 'tutors.user_id')
      ->leftjoin('grades', 'tutors.grade', '=', 'grades.id')
      ->join('zips', 'users.zip_id', '=', 'zips.id')
      ->findOrFail($id);

      return $tutor;
    }

}
