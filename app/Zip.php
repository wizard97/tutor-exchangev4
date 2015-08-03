<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zip extends Model
{
    protected $table = 'zips';
    protected $primaryKey = 'id';

    public function schools()
    {
      return $this->hasMany('App\School', 'zip_id', 'zip_code');
    }

    public function users()
    {
      return $this->hasMany('App\User', 'zip_id', 'zip_code');
    }
}
