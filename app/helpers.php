<?php
// My common functions
function isActiveRoute($route)
{
    if(Request::is($route . '/*') OR Request::is($route) OR Route::is($route) OR Route::is($route))
    {
        $active = "active";
    }
    else
    {
        $active = '';
    }

    return $active;
}

function isExactRoute($route)
{
    if(Request::is($route))
    {
        $active = 'active';
    }

    else
    {
        $active = '';
    }

    return $active;
}

function print_stars($rating)
{
  $string = '';
  $star_count = floor($rating);
  for ($i = 0; $i < $star_count; $i++) $string .= '<i style="color: #FEC601" class="fa fa-star"></i>';

  $delta = $rating - $star_count;
  if ($delta >= 0.25) {
    if ($delta < 0.75) $string .= '<i style="color: #FEC601" class="fa fa-star-half-o"></i>';
    else $string .= '<i style="color: #FEC601" class="fa fa-star"></i>';
    for ($i = 0; $i < 4 - $star_count; $i++) $string .= '<i style="color: #FEC601" class="fa fa-star-o"></i>';
  }
  else
  {
    for ($i = 0; $i < 5 - $star_count; $i++) $string .= '<i style="color: #FEC601" class="fa fa-star-o"></i>';
  }
  return $string;
}

function escape_sql($string)
{
  return \DB::connection()->getPdo()->quote($string);
}

function dump_sql()
{
  \DB::listen(function($qe) {
    $new_string = $qe->sql;
    foreach($qe->bindings as $key => $value)
    {
      $new_string = preg_replace('/\?/', "'".$value."'", $new_string, 1);
    }
  echo str_replace("''","'",$new_string);
  echo "<br><br>Query length: ".strlen($new_string);
  var_dump($qe->bindings);
  var_dump($qe->time);
  });
  }
?>
