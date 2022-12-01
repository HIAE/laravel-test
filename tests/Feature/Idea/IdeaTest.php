<?php

use App\Models\Category as CategoryModel;
use App\Models\Idea as IdeaModel;
use App\Models\User as UserModel;

test('model idea has been soft deleted', function () {
    // Arrange
    $idea = IdeaModel::factory()->create();

    // Act
    $response = $this->deleteJson(route('idea.destroy', $idea->uuid));

    // Assert
    $response->assertNoContent();
    $this->assertSoftDeleted($idea);
});

test('create idea', function () {
    // Arrange
    $idea = IdeaModel::factory()->make();
    $data = $idea->toArray();

    $data['user_id'] = UserModel::find($data['user_id'])->uuid;
    $data['category_id'] = CategoryModel::find($data['category_id'])->uuid;

    // Act
    $response = $this->postJson(route('idea.store', $data));

    // Assert
    $response->assertCreated();
    $this->assertDatabaseHas('ideas', [
        'uuid' => $data['uuid'],
        'idea' => $data['idea'],
        'user_id' => $idea->user_id,
        'category_id' => $idea->category_id,
    ]);
});

test('update idea', function () {
    // Arrange
    $idea = IdeaModel::factory()->create();
    $data = ['idea' => fake()->word];

    // Act
    $response = $this->putJson("/api/v1/ideas/$idea->uuid", $data);

    // Assert
    $response->assertOk();
    $this->assertDatabaseHas('ideas', [
        "uuid" => $idea->uuid,
        "idea" => $data["idea"],
    ]);
});

test('show idea', function () {
    // Arrange
    $idea = IdeaModel::factory()->create();

    // Act
    $response = $this->getJson(route('idea.show', $idea->uuid));

    // Assert
    expect($response->json('data'))
        ->id->toBe($idea->uuid)
        ->idea->toBe($idea->idea)
        ->user->toBeArray()->not->toBeEmpty()
        ->category->toBeArray()->not->toBeEmpty();
});

test('list idea', function () {
    // Arrange
    $idea = IdeaModel::factory()->count(3)->create();

    // Act
    $response = $this->getJson(route('idea.index'));

    // Assert
    expect($response->json('data'))
        ->toBeArray()
        ->not->toBeEmpty()
        ->toHaveCount($idea->count());
});
