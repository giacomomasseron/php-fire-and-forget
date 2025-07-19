<?php

namespace GiacomoMasseroni\FireAndForget\Drivers;

use Exception;
use GiacomoMasseroni\FireAndForget\Contracts\DriverInterface;
use GiacomoMasseroni\FireAndForget\Enums\MethodEnum;
use GiacomoMasseroni\FireAndForget\Exceptions\NoSocket;

class Socket extends AbstractDriver implements DriverInterface
{
    /**
     * @param MethodEnum $method
     * @param string $url
     * @param array<string, string>|null $parameters
     * @throws NoSocket
     */
    public function send(MethodEnum $method, string $url, ?array $parameters = null): void
    {
        $parts = parse_url($url);

        try {
            $parts['port'] = $parts['port'] ?? $parts['scheme'] === 'https' ? 443 : 80;
            $socket = $this->openSocket($this->socketScheme($parts['scheme']) . '://' . $parts['host'], $parts['port']);
        } catch (Exception $e) {
            throw new NoSocket('Error during open socket: ' . $e->getMessage());
        }

        if (! $socket) {
            throw new NoSocket('Error during open socket: socket is null');
        }

        $request = $method->value . $parts['path'] . '?' . $parts['query'] . 'HTTP/1.1' . "\r\n";
        $request .= 'Host:' . $parts['host'] . "\r\n";

        if (!is_null($this->bearerToken)) {
            $request .= "Authorization: Bearer $this->bearerToken\r\n";
        }

        foreach ($this->headers ?? [] as $key => $value) {
            $request .= "$key: $value\r\n";
        }

        $request .= 'Content-Type:application/x-www-form-urlencoded' . "\r\n";
        $request .= 'Content-Length:' . strlen($parts['query']) . "\r\n";
        $request .= 'Connection:Close' . "\r\n\r\n";

        fwrite($socket, $request);
        fclose($socket);
    }

    // @phpstan-ignore-next-line
    protected function openSocket(string $host, int $port)
    {
        return fsockopen($host, $port, $errorNumber, $errorString, 0.2);
    }

    /**
     * @throws NoSocket
     */
    private function socketScheme(string $scheme): string
    {
        return match ($scheme) {
            'http' => 'tcp',
            'https' => 'ssl',
            default => throw new NoSocket("Unsupported scheme: $scheme"),
        };
    }
}
