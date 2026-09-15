<?php

use App\Models\User;
use App\Models\Visitor;

test('visitors can be created without authentication', function () {
    $response = $this->postJson('/api/visitors', [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'phone_number' => '11999998888',
        'additional_visitors' => ['Jane Doe'],
    ]);

    $response->assertCreated()
        ->assertJsonPath('email', 'john@example.com');

    $this->assertDatabaseHas('visitors', ['email' => 'john@example.com']);
});

test('creating a visitor validates the required fields', function () {
    $this->postJson('/api/visitors', [])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['name', 'email']);
});

test('creating a visitor with a duplicated email is rejected', function () {
    Visitor::factory()->create(['email' => 'john@example.com']);

    $this->postJson('/api/visitors', [
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ])->assertUnprocessable()
        ->assertJsonValidationErrors('email');
});

test('visitor endpoints require authentication', function (string $method, string $uri) {
    $method = $method.'Json';

    $this->{$method}($uri)->assertUnauthorized();
})->with([
    'index' => ['get', '/api/visitors'],
    'show' => ['get', '/api/visitors/1'],
    'update' => ['put', '/api/visitors/1'],
    'destroy' => ['delete', '/api/visitors/1'],
]);

test('authenticated users can list visitors', function () {
    Visitor::factory()->count(3)->create();

    $user = User::factory()->create();
    $token = $user->createToken('api')->plainTextToken;

    $this->withToken($token)->getJson('/api/visitors')
        ->assertOk()
        ->assertJsonCount(3);
});

test('authenticated users can update a visitor', function () {
    $visitor = Visitor::factory()->create();

    $user = User::factory()->create();
    $token = $user->createToken('api')->plainTextToken;

    $this->withToken($token)->putJson("/api/visitors/{$visitor->id}", [
        'name' => 'Updated Name',
        'email' => 'updated@example.com',
    ])->assertOk()
        ->assertJsonPath('name', 'Updated Name');

    $this->assertDatabaseHas('visitors', [
        'id' => $visitor->id,
        'name' => 'Updated Name',
    ]);
});

test('authenticated users can delete a visitor', function () {
    $visitor = Visitor::factory()->create();

    $user = User::factory()->create();
    $token = $user->createToken('api')->plainTextToken;

    $this->withToken($token)->deleteJson("/api/visitors/{$visitor->id}")
        ->assertNoContent();

    $this->assertDatabaseMissing('visitors', ['id' => $visitor->id]);
});
