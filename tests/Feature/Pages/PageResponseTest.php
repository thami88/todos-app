<?php

use App\Models\Course;
use App\Models\Video;

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

it('does not find JetStream registraation page', function () {
    // Act & Assert
    get('register')
        ->assertNotFound();
});

it('gives back sucessful response for video page', function () {
    // Arrange
    $course = Course::factory()
        ->has(Video::factory())
        ->create();

    // Act & Assert
    LoginAsUser();
    get(route('page.course-videos', $course))
        ->assertOk();
});
