<?php

namespace GiacomoMasseroni\FireAndForget;

final class Logger
{
    public static function writeLog(mixed $log): void
    {
        file_put_contents('./log.log', (is_array($log) ? print_r($log, true) : $log) . PHP_EOL, FILE_APPEND);
    }
}
