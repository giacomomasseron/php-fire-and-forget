<?php

namespace GiacomoMasseroni\FireAndForget\Enums;

use GiacomoMasseroni\FireAndForget\Drivers\Curl;
use GiacomoMasseroni\FireAndForget\Drivers\Socket;

enum DriverEnum: string
{
    case CURL = 'curl';
    case SOCKET = 'socket';

    public static function getDriverClass(DriverEnum $driver): string
    {
        return match ($driver) {
            self::CURL => Curl::class,
            self::SOCKET => Socket::class,
        };
    }
}
