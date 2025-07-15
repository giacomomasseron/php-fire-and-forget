<?php

namespace GiacomoMasseroni\FireAndForget\Exceptions;

use GiacomoMasseroni\FireAndForget\Enums\MethodEnum;

class MethodNotAllowed extends FireAndForgetException
{
    public function __construct(MethodEnum $method, string $driver)
    {
        parent::__construct("The method {$method->value} is not allowed for driver $driver.", 400);
    }
}
