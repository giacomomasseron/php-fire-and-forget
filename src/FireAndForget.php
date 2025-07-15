<?php

namespace GiacomoMasseroni\FireAndForget;

use GiacomoMasseroni\FireAndForget\Contracts\DriverInterface;
use GiacomoMasseroni\FireAndForget\Drivers\Curl;
use GiacomoMasseroni\FireAndForget\Drivers\Socket;
use GiacomoMasseroni\FireAndForget\Enums\DriverEnum;
use GiacomoMasseroni\FireAndForget\Enums\MethodEnum;
use GiacomoMasseroni\FireAndForget\Exceptions\FireAndForgetException;

/**
 * @method static FireAndForget withHeaders(string[] $headers)
 * @method static FireAndForget withBearerToken(string $token)
 * @method static FireAndForget driver(DriverEnum $driver)
 * @method static void get(string $ur, ?DriverEnum $driver = null)
 * @method static void post(string $url, ?string[] $parameters, ?DriverEnum $driver = null)
 * @method static void put(string $url, ?string[] $parameters, ?DriverEnum $driver = null)
 * @method static void delete(string $url, ?DriverEnum $driver = null)
 */
final class FireAndForget
{
    private static FireAndForget $instance;

    /**
     * @var array<class-string<DriverInterface>>
     */
    private array $drivers = [
        Socket::class,
        Curl::class,
    ];

    /**
     * @var array<string, string>
     */
    private array $headers = [];

    private ?string $bearerToken = null;

    private ?DriverEnum $driver = null;

    /**
     * Singleton's constructor should not be public. However, it can't be
     * private either if we want to allow subclassing.
     */
    protected function __construct()
    {
    }

    /**
     * The method you use to get the Singleton's instance.
     */
    private static function getInstance(): FireAndForget
    {
        if (!isset(self::$instance)) {
            self::$instance = new FireAndForget();
        }

        return self::$instance;
    }

    public static function __callStatic(string $name, mixed $arguments): FireAndForget
    {
        $instance = self::getInstance();
        $instance->$name(...$arguments);

        return $instance;
    }

    public function __call(string $name, mixed $arguments): FireAndForget
    {
        $this->$name(...$arguments);

        return $this;
    }

    private function driver(DriverEnum $driver): FireAndForget
    {
        $instance = self::getInstance();
        $instance->driver = $driver;

        return $instance;
    }

    /**
     * @param array<string, string> $headers
     * @return FireAndForget
     */
    private function withHeaders(array $headers): FireAndForget
    {
        $instance = self::getInstance();
        $instance->headers = $headers;
        //$instance->driver->setHeaders($headers);

        return $instance;
    }

    private function withBearerToken(string $token): FireAndForget
    {
        $instance = self::getInstance();
        $instance->bearerToken = $token;
        //$instance->driver->setBearerToken($token);

        return $instance;
    }

    /**
     * @throws FireAndForgetException
     */
    private function get(string $url): void
    {
        $instance = self::getInstance();
        $instance->sendRequest(MethodEnum::GET, $url);
    }

    /**
     * @param array<string, string>|null $parameters
     * @throws FireAndForgetException
     */
    private function post(string $url, ?array $parameters = null): void
    {
        $instance = self::getInstance();
        $instance->sendRequest(MethodEnum::POST, $url, $parameters);
    }

    /**
     * @param array<string, string>|null $parameters
     * @throws FireAndForgetException
     */
    private function put(string $url, ?array $parameters = null): void
    {
        $instance = self::getInstance();
        $instance->sendRequest(MethodEnum::PUT, $url, $parameters);
    }

    /**
     * @throws FireAndForgetException
     */
    private function delete(string $url): void
    {
        $instance = self::getInstance();
        $instance->sendRequest(MethodEnum::DELETE, $url);
    }

    /**
     * @param MethodEnum $method
     * @param string $url
     * @param array<string, string>|null $parameters
     * @return void
     * @throws FireAndForgetException
     */
    private function sendRequest(MethodEnum $method, string $url, ?array $parameters = null): void
    {
        $instance = self::getInstance();

        if ($this->driver !== null) {
            $driverClass = DriverEnum::getDriverClass($this->driver);
            if (! in_array($driverClass, $this->drivers)) {
                throw new FireAndForgetException("Driver {$driverClass} is not supported.");
            }
            $this->drivers = [$driverClass];
        }

        $lastKey = array_key_last($this->drivers);

        foreach ($this->drivers as $key => $driver) {
            try {
                $driver = new $driver();

                if (count($this->headers) > 0) {
                    $driver->setHeaders($this->headers);
                }

                if (! empty($instance->bearerToken)) {
                    $driver->setBearerToken($instance->bearerToken);
                }

                $driver->send($method, $url, $parameters);

                $this->resetInstance();
                return;
            } catch (FireAndForgetException $exception) {
                if ($key == $lastKey) {
                    $this->resetInstance();

                    throw $exception;
                }
            }
        }
    }

    private function resetInstance(): void
    {
        self::$instance = new FireAndForget();
    }
}
