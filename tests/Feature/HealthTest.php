<?php

test('the web health endpoint reports the application is healthy', function () {
    $this->getJson('/health')
        ->assertOk()
        ->assertJson(['status' => 'ok', 'database' => true]);
});

test('the api health endpoint reports the application is healthy', function () {
    $this->getJson('/api/health')
        ->assertOk()
        ->assertJson(['status' => 'ok', 'database' => true]);
});
