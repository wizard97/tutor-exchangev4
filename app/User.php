<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['fname', 'lname', 'zip', 'lat', 'lon', 'address', 'email', 'password', 'account_type', 'terms_conditions', 'activation_hash', 'user_active'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token', 'activation_hash', 'user_active'];


    public function tutor()
    {
      return $this->hasOne('App\Tutor', 'user_id', 'id');
    }

    public function saved_tutors()
    {
      return $this->belongsToMany('App\Tutor', 'saved_tutors', 'user_id', 'tutor_id')->withTimestamps();
    }

    public function zip()
    {
      return $this->belongsTo('App\Zip', 'zip_id', 'id');
    }

    public function reviews()
    {
      return $this->hasMany('App\Review', 'reviewer_id', 'id');
    }

    public function tutor_contacts()
    {
      return $this->hasMany('App\TutorContact', 'user_id', 'id');
    }
}
