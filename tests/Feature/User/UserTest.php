<?php

use App\Models\User as UserModel;
use App\Models\Group as GroupModel;

test('model has been soft deleted', function () {
    // Arrange
    $user = UserModel::factory()->create();

    // Act
    $response = $this->deleteJson(route('user.destroy', $user->uuid));

    // Assert
    $response->assertNoContent();
    $this->assertSoftDeleted($user);
});

test('create user', function () {
    // Arrange
    $user = UserModel::factory()->make();
    $data = $user->toArray();

    // Act
    $response = $this->postJson(route('user.store', $data));

    // Assert
    $response->assertCreated();
    $this->assertDatabaseHas('users', [
        'uuid' => $data['uuid'],
        'name' => $data['name'],
        'email' => $data['email'],
    ]);
});

test('update user', function () {
    // Arrange
    $user = UserModel::factory()->create();
    $newData = [
        'name' => fake()->name(),
        'email' => fake()->unique()->safeEmail(),
    ];

    // Act
    $response = $this->putJson("/api/v1/users/$user->uuid", $newData);

    // Assert
    $response->assertOk();
    $this->assertDatabaseHas('users', [
        "uuid" => $user->uuid,
        "name" => $newData["name"],
        "email" => $newData["email"],
    ]);
});

test('show user', function () {
    // Arrange
    $group = GroupModel::factory()->create();
    $user = UserModel::factory()->create();
    $user->groups()->attach($group->id);

    // Act
    $response = $this->getJson(route('user.show', $user->uuid));

    // Assert
    expect($response->json())
        ->id->toBe($user->uuid)
        ->name->toBe($user->name)
        ->email->toBe($user->email)
        ->groups->toBeArray()->not->toBeEmpty();
});

test('list users', function () {
    // Arrange
    $user = UserModel::factory()->count(3)->create();

    // Act
    $response = $this->getJson(route('user.index'));

    // Assert
    expect($response->json('data'))
        ->toBeArray()
        ->not->toBeEmpty()
        ->toHaveCount($user->count());
});
