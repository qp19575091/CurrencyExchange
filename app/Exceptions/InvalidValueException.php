<?php

namespace App\Exceptions;

use Symfony\Component\CssSelector\Exception\InternalErrorException;

class InvalidValueException extends InternalErrorException
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
