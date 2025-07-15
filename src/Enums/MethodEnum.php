<?php

namespace GiacomoMasseroni\FireAndForget\Enums;

enum MethodEnum: string
{
    case POST = 'POST';
    case GET = 'GET';
    case PUT = 'PUT';
    case DELETE = 'DELETE';
}
