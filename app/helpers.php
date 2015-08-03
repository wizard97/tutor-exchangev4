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

/*
function val($value, $default = null)
{
    if (isset($value) && !empty($value))
    {
      return $value;
    }
    else return $default;
}

function exists($var)
{
  if (isset($var) && !empty($var))
  {
    return true;
  }
  else return false;
}
*/

?>
