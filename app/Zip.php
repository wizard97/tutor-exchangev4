<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zip extends Model
{
    protected $table = 'zips';

    public function schools()
    {
      return $this->hasMany('App\School', 'zip_code', 'zip_code');
    }

    public function users()
    {
      return $this->hasMany('App\User', 'zip', 'zip_code');
    }
}
