<?php
// My common functions
function isActiveRoute($route)
{
    if(Request::is($route . '/*') OR Request::is($route))
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

?>
