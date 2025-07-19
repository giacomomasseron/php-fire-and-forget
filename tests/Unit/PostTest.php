<?php

use GiacomoMasseroni\FireAndForget\Enums\DriverEnum;
use GiacomoMasseroni\FireAndForget\Exceptions\MethodNotAllowed;
use GiacomoMasseroni\FireAndForget\FireAndForget;

it('slow api', function () {
    $before = microtime(true);

    FireAndForget::post('https://fakeresponder.com/?sleep=5000');

    $after = microtime(true);

    $this->assertTrue(($after - $before) < 1, 'The request should not block the execution');
});

it('slow api with exception', function () {
    FireAndForget::driver(DriverEnum::CURL)->post('https://fakeresponder.com/?sleep=5000');
})->throws(MethodNotAllowed::class);

it('slow api with bearer token', function () {
    $before = microtime(true);

    FireAndForget::withBearerToken('bearer_token')
        ->post('https://fakeresponder.com/?sleep=5000');

    $after = microtime(true);

    $this->assertTrue(($after - $before) < 1, 'The request should not block the execution');
});

it('slow api with headers', function () {
    $before = microtime(true);

    FireAndForget::withHeaders([
        'X-Header' => 'Test',
        'X-Header2' => 'Test2',
    ])->post('https://fakeresponder.com/?sleep=5000');

    $after = microtime(true);

    $this->assertTrue(($after - $before) < 1, 'The request should not block the execution');
});
