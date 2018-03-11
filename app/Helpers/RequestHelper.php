<?php

if (!function_exists('requestContainsMultipleObjects')) {
    function requestContainsMultipleObjects()
    {
        $data = Request::all();
        return is_array(reset($data));
    }
}
