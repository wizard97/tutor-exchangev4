<?php

namespace App\Models\Statistic;

use Illuminate\Database\Eloquent\Model;

class Stat extends Model
{
  public $timestamps = false;

  static public function incr_search()
  {
    $res = Stat::firstOrFail();
    $res->searches++;
    $res->save();
    return $res->searches;
  }

  static public function incr_visitors()
  {
    $res = Stat::firstOrFail();
    $res->visitors++;
    $res->save();
    return $res->visitors;
  }
    //
}
