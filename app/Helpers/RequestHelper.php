<?php

function requestIsArray()
{
    $data = Request::all();
    // $data = $request->all();
    return is_array(reset($data));
}
