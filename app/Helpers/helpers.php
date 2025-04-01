<?php
// active helper function
if (!function_exists('active')) {
    function active($route,$class = 'active')
    {
        return request()->routeIs($route) ? $class : '';
    }
}
?>