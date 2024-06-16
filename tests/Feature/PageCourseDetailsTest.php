<?php

use App\Models\Course;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('shows course details', function () {
    // Arrange
    $course = Course::factory()->create([
        'tagline' => 'Course tagline',
        'image' => 'image.png',
        'learnings' => [
            'learn laravel routes',
            'learn laravel views',
            'learn laravel commands',
        ],
    ]);
    // Act & Assert
    get(route('course-details', $course))
        ->assertOk()
        ->assertSeeText([
            $course->title,
            $course->description,
            'Course tagline',
            'learn laravel routes',
            'learn laravel views',
            'learn laravel commands',
        ])
        ->assertSee('image.png');
});

it('shows course video count', function () {
    // Arrange
    $course = Course::factory()->create();
    Video::factory()->count(3)->create([
        'course_id' => $course->id
    ]);
    // Act & Assert
    get(route('course-details', $course))
        ->assertOk()
        ->assertSeeText('3videos');
});
