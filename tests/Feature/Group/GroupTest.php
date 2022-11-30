<?php

use App\Models\Group as GroupModel;

test('model has been soft deleted', function () {
    // Arrange
    $group = GroupModel::factory()->create();

    // Act
    $response = $this->deleteJson(route('group.destroy', $group->uuid));

    // Assert
    $response->assertNoContent();
    $this->assertSoftDeleted($group);
});

test('create group', function () {
    // Arrange
    $group = GroupModel::factory()->make(['description' => 'profissional']);
    $data = $group->toArray();

    // Act
    $response = $this->postJson(route('group.store', $data));

    // Assert
    $response->assertCreated();
    $this->assertDatabaseHas('groups', [
        "uuid" => $data["uuid"],
        "description" => $data["description"],
    ]);
});
