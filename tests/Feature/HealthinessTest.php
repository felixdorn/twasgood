<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('basic pages do not throw an error', function (string $path) {
    $this->seed();

    $response = $this->get($path);

    $response->assertStatus(200);
})->with([
    '/',
    '/search',
    '/a-propos',
]);
