<?php

use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('shows courses overview', function () {

    // Arrange
    Course::factory()->create([
        'title' => 'Course A',
        'description' => 'Course Description A'
    ]);
    Course::factory()->create([
        'title' => 'Course B',
        'description' => 'Course Description B'
    ]);
    Course::factory()->create([
        'title' => 'Course C',
        'description' => 'Course Description C'
    ]);

    // Act and Assert
    get(route('home'))
    ->assertSeeText([
        'Course A',
        'Course Description A',
        'Course B',
        'Course Description B',
        'Course C',
        'Course Description C',
    ]);

});

it('shows only released courses', function () {

});

it('shoes courses by release date', function (){

});


