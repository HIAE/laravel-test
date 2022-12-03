<?php

use App\Models\Comment as CommentModel;
use App\Models\Idea as IdeaModel;
use App\Models\User as UserModel;

test('model comment has been soft deleted', function () {
    // Arrange
    $comment = CommentModel::factory()->create();

    // Act
    $response = $this->deleteJson(route('comment.destroy', $comment->uuid));

    // Assert
    $response->assertNoContent();
    $this->assertSoftDeleted($comment);
});

test('create comment', function () {
    // Arrange
    $comment = CommentModel::factory()->make();
    $data = $comment->toArray();

    $data['user_id'] = UserModel::find($data['user_id'])->uuid;
    $data['idea_id'] = IdeaModel::find($data['idea_id'])->uuid;

    // Act
    $response = $this->postJson(route('comment.store', $data));

    // Assert
    $response->assertCreated();
    $this->assertDatabaseHas('comments', [
        'uuid' => $data['uuid'],
        'commentary' => $data['commentary'],
        'user_id' => $comment->user_id,
        'idea_id' => $comment->idea_id,
    ]);
});

test('update comment', function () {
    // Arrange
    $comment = CommentModel::factory()->create();
    $data = ['commentary' => fake()->word];

    // Act
    $response = $this->putJson("/api/v1/comments/$comment->uuid", $data);

    // Assert
    $response->assertOk();
    $this->assertDatabaseHas('comments', [
        "uuid" => $comment->uuid,
        "commentary" => $data["commentary"],
    ]);
});

test('show comment', function () {
    // Arrange
    $comment = CommentModel::factory()->create();

    // Act
    $response = $this->getJson(route('comment.show', $comment->uuid));

    // Assert
    expect($response->json('data'))
        ->id->toBe($comment->uuid)
        ->commentary->toBe($comment->commentary)
        ->user->toBeArray()->not->toBeEmpty()
        ->idea->toBeArray()->not->toBeEmpty();
});

test('list comment', function () {
    // Arrange
    $comment = CommentModel::factory()->count(3)->create();

    // Act
    $response = $this->getJson(route('comment.index'));

    // Assert
    expect($response->json('data'))
        ->toBeArray()
        ->not->toBeEmpty()
        ->toHaveCount($comment->count());
});
