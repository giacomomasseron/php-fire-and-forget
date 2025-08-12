<?php

namespace GiacomoMasseroni\FireAndForget;

final class Logger
{
    public static function writeLog(mixed $log): void
    {
        file_put_contents('./log.log', (is_string($log) ? $log : print_r($log, true)) . PHP_EOL, FILE_APPEND);
    }
}
