<?php

test('basic pages do not throw an error', function (string $path) {
    $response = $this->get($path);

    $response->assertStatus(200);
})->with([
    '/',
    '/search',
    '/a-propos',
]);
