<?php

use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('gives back successful response for home page', function () {
    // Act & Assert
    get(route('home'))->assertOk();
});

it('gives back sucessful response for course details page', function () {
    // Arrange
    $course = Course::factory()->create();
    // Act & Assert
    get(route('course-details', $course))
        ->assertOk();
});
