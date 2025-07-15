<?php

use GiacomoMasseroni\FireAndForget\FireAndForget;

it('slow api', function () {
    $before = microtime(true);

    FireAndForget::get('https://fakeresponder.com/?sleep=5000');
    //exec("curl https://fakeresponder.com/?sleep=5000 > /dev/null 2>&1 &");

    $after = microtime(true);

    $this->assertTrue(($after - $before) < 1, 'The request should not block the execution');
});

it('slow api with bearer token', function () {
    $before = microtime(true);

    FireAndForget::withBearerToken('bearer_token')->get('https://fakeresponder.com/?sleep=5000');

    $after = microtime(true);

    $this->assertTrue(($after - $before) < 1, 'The request should not block the execution');
});

it('slow api with headers', function () {
    $before = microtime(true);

    FireAndForget::withHeaders([
        'X-Header' => 'Test',
        'X-Header2' => 'Test2',
    ])->get('https://fakeresponder.com/?sleep=5000');

    $after = microtime(true);

    $this->assertTrue(($after - $before) < 1, 'The request should not block the execution');
});