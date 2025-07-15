<?php

namespace GiacomoMasseroni\FireAndForget\Drivers;

use GiacomoMasseroni\FireAndForget\Contracts\DriverInterface;
use GiacomoMasseroni\FireAndForget\Enums\MethodEnum;
use GiacomoMasseroni\FireAndForget\Exceptions\FireAndForgetException;
use GiacomoMasseroni\FireAndForget\Exceptions\MethodNotAllowed;

class Curl extends AbstractDriver implements DriverInterface
{
    /**
     * @param MethodEnum $method
     * @param string $url
     * @param array<string, string>|null $parameters
     * @return void
     * @throws MethodNotAllowed
     */
    public function send(MethodEnum $method, string $url, ?array $parameters = null): void
    {
        if ($method->value !== MethodEnum::GET->value) {
            throw new MethodNotAllowed($method, static::class);
        }

        exec("curl {$this->addBearerToken()} {$this->addHeaders()} {$this->addParamsToUrl($url, $parameters)} > /dev/null 2>&1 &");
    }

    /**
     * @param string $url
     * @param array<string, string>|null $parameters
     * @return string
     */
    private function addParamsToUrl(string $url, ?array $parameters = null): string
    {
        if (empty($parameters)) {
            return $url;
        }

        $query = http_build_query($parameters);
        return !str_contains($url, '?') ? $url . '?' . $query : $url . '&' . $query;
    }

    private function addBearerToken(): string
    {
        if (empty($this->bearerToken)) {
            return '';
        }

        return  "-H 'Authorization: Bearer " . $this->bearerToken . "' ";
    }

    private function addHeaders(): string
    {
        $headerString = '';
        foreach ($this->headers ?? [] as $key => $value) {
            $headerString .= "-H '" . $key . ": " . $value . "' ";
        }

        return $headerString;
    }
}
