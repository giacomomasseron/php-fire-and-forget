<?php

namespace GiacomoMasseroni\FireAndForget\Contracts;

use GiacomoMasseroni\FireAndForget\Enums\MethodEnum;

interface DriverInterface
{
    /**
     * @param MethodEnum $method
     * @param string $url
     * @param array<string, string>|null $parameters
     * @return void
     */
    public function send(MethodEnum $method, string $url, ?array $parameters = null): void;

    public function setBearerToken(string $token): DriverInterface;

    /**
     * @param array<string, string> $headers
     * @return DriverInterface
     */
    public function setHeaders(array $headers): DriverInterface;
}
