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

test('update group', function () {
    // Arrange
    $group = GroupModel::factory()->create();
    $data = ['description' => 'new_user'];

    // Act
    $response = $this->putJson("/api/v1/groups/$group->uuid", $data);

    // Assert
    $response->assertOk();
    $this->assertDatabaseHas('groups', [
        "uuid" => $group->uuid,
        "description" => $data["description"],
    ]);
});

test('show group', function () {
    // Arrange
    $group = GroupModel::factory()->create();
    $this->postJson(route('group.store', $group->toArray()));

    // Act
    $response = $this->getJson(route('group.show', $group->uuid));

    // Assert
    expect(JSON_ENCODE($response->json()))
        ->json()
        ->id->toBe($group->id)
        ->uuid->toBe($group->uuid)
        ->description->toBe($group->description);
});

test('list groups', function () {
    // Arrange
    $group = GroupModel::factory()->count(3)->create();

    // Act
    $response = $this->getJson(route('group.index'));

    // Assert
    expect($response->json('data'))
        ->toHaveCount($group->count());

    expect($response->json('data'))->toMatchArray($group->toArray());
});
