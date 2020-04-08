<?php


namespace Floinay\LaravelJwt\Exceptions;


use Throwable;

class WrongUserAgentException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
