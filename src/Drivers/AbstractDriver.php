<?php

namespace GiacomoMasseroni\FireAndForget\Drivers;

use GiacomoMasseroni\FireAndForget\Contracts\DriverInterface;

abstract class AbstractDriver implements DriverInterface
{
    protected ?string $bearerToken = null;

    /**
     * @var array<string, string>|null
     */
    protected ?array $headers = null;

    public function setBearerToken(string $token): DriverInterface
    {
        $this->bearerToken = $token;
        return $this;
    }

    /**
     * @param array<string, string> $headers
     * @return DriverInterface
     */
    public function setHeaders(array $headers): DriverInterface
    {
        $this->headers = $headers;
        return $this;
    }
}
