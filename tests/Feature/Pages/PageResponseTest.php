<?php

use App\Models\Course;
use App\Models\User;

use function Pest\Laravel\get;


it('gives back successful response for home page', function () {
    // Act & Assert
    get(route('pages.home'))->assertOk();
});

it('gives back sucessful response for course details page', function () {
    // Arrange
    $course = Course::factory()
        ->released()
        ->create();
    // Act & Assert
    get(route('pages.course-details', $course))
        ->assertOk();
});

it('gives back sucessful response for dashboard page', function () {
    // Arrange & Act & Assert
    LoginAsUser();
    get(route('pages.dashboard'))
        ->assertOk();
});
