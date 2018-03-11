<?php

namespace App\Exceptions;

use Exception;

class NoSuchSectionExistsException extends Exception
{
    protected $message = 'No such combination of multiplier and pie value exists.';
}
