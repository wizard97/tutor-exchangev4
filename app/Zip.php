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
      return $this->hasMany('App\User', 'zip_id', 'id');
    }

    public function scopeHaversine($query, $lat, $long, $dist_var, $max_dist, $limit, &$selector)
    {
      $lat2 = escape_sql((float)$lat);
      $long2 = escape_sql((float)$long);
      $dist_var2 = esacpe_sql((float)$dist_var);
      $selector = sprintf("3959*ACOS(COS(RADIANS(zips.lat)) * COS(RADIANS(%s)) * COS(RADIANS(zips.lon) - RADIANS(%s)) + SIN(RADIANS(zips.lat)) * SIN(RADIANS(%s))) AS %s",
        $lat2, $long2, $lat2, $dist_var2);
      //if to to limit max, dist
      if($limit)
      {
        $query = $query->whereRaw("zips.lat BETWEEN (? - (? / 69.0)) AND (? + (? / 69.0))", [$lat, $dist_var, $lat, $dist_var])
        ->whereRaw("zips.long BETWEEN (? - (? / (69.0 * COS(RADIANS(?))))) AND (? + (? / (69.0 * COS(RADIANS(?)))))", [$long, $dist_var, $long, $long, $dist_var, $long])
        ->having($dist_var, '<=', $max_dist);
      }

      return  $query;

    }

}
