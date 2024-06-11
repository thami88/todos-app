<?php

use App\Models\Course;
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

it('it shows course vide count', function () {

});
