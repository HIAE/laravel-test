<?php

use App\Models\Category as CategoryModel;

test('model category has been soft deleted', function () {
    // Arrange
    $category = CategoryModel::factory()->create();

    // Act
    $response = $this->deleteJson(route('category.destroy', $category->uuid));

    // Assert
    $response->assertNoContent();
    $this->assertSoftDeleted($category);
});

test('create category', function () {
    // Arrange
    $category = CategoryModel::factory()->make();
    $data = $category->toArray();

    // Act
    $response = $this->postJson(route('category.store', $data));

    // Assert
    $response->assertCreated();
    $this->assertDatabaseHas('categories', [
        'uuid' => $data['uuid'],
        'category' => $data['category'],
    ]);
});

test('update category', function () {
    // Arrange
    $category = CategoryModel::factory()->create();
    $case = collect(\App\Enum\CategoryEnum::cases())->random();

    while ($category->category->value === $case->value) {
        $case = collect(\App\Enum\CategoryEnum::cases())->random();
    }

    $data = ['category' => $case->value];

    // Act
    $response = $this->putJson("/api/v1/categories/$category->uuid", $data);

    // Assert
    $response->assertOk();
    $this->assertDatabaseHas('categories', [
        "uuid" => $category->uuid,
        "category" => $data["category"],
    ]);
});

test('show category', function () {
    // Arrange
    $category = CategoryModel::factory()->create();

    // Act
    $response = $this->getJson(route('category.show', $category->uuid));

    // Assert
    expect($response->json('data'))
        ->id->toBe($category->uuid)
        ->category->toBe($category->category->value);
});

test('list category', function () {
    // Arrange
    $category = CategoryModel::factory()->count(3)->create();

    // Act
    $response = $this->getJson(route('category.index'));

    // Assert
    expect($response->json('data'))
        ->toBeArray()
        ->not->toBeEmpty()
        ->toHaveCount($category->count());
});
