<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stat extends Model
{
  public $timestamps = false;

  static public function incr_search()
  {
    $res = \App\Stat::firstOrFail();
    $res->searches++;
    $res->save();
    return $res->searches;
  }

  static public function incr_visitors()
  {
    $res = \App\Stat::firstOrFail();
    $res->visitors++;
    $res->save();
    return $res->visitors;
  }
    //
}
