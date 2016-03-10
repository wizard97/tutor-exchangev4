<?php

namespace App\Models\User;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;


class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;
    use Messagable;

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
    protected $fillable = ['fname', 'lname', 'zip', 'lat', 'lon', 'address',
        'email', 'password', 'account_type', 'terms_conditions',
        'activation_hash', 'user_active'];

    /**
    * The attributes excluded from the model's JSON form.
    *
    * @var array
    */
    protected $hidden = ['password', 'remember_token', 'activation_hash',
        'user_active', 'address', 'lat', 'lon'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'account_type' => 'integer',
        'has_picture' => 'boolean',
        'user_active' => 'boolean'
    ];


    public function tutor()
    {
        return $this->hasOne('App\Models\Tutor\Tutor', 'user_id', 'id');
    }

    public function saved_tutors()
    {
        return $this->belongsToMany('App\Models\Tutor\Tutor', 'saved_tutors', 'user_id', 'tutor_id')->withTimestamps();
    }

    public function zip()
    {
        return $this->belongsTo('App\Models\Zip\Zip', 'zip_id', 'id');
    }

    public function reviews()
    {
        return $this->hasMany('App\Models\Review\Review', 'reviewer_id', 'id');
    }

    public function getName()
    {
        return $this->fname.' '.$this->lname;
    }

    // SCOPES
    /**
    * Get user account and location info that is safe to transmit to client side
    *
    */
    public function scopeSafeUserInfo($query)
    {
        return $query
            ->join('zips', 'zips.id', '=', 'users.zip_id')
            ->select(\DB::raw("CONCAT(users.fname,' ',users.lname) AS full_name"),
            'users.id', 'users.account_type', 'zips.city', 'zips.state_prefix');
    }

}
