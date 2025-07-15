<?php

namespace GiacomoMasseroni\FireAndForget\Exceptions;

use Throwable;

class NoSocket extends FireAndForgetException
{
    public function __construct(string $message = '', int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
