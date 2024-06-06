<?php

use App\Models\Course;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('shows courses overview', function () {

    // Arrange
    Course::factory()->create([
        'title' => 'Course A',
        'description' => 'Course Description A',
        'released_at' => Carbon::now()
    ]);
    Course::factory()->create([
        'title' => 'Course B',
        'description' => 'Course Description B',
        'released_at' => Carbon::now()
    ]);
    Course::factory()->create([
        'title' => 'Course C',
        'description' => 'Course Description C',
        'released_at' => Carbon::now()
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
    // Arrage
    Course::factory()->create([
        'title' => 'Course A',
        'released_at' => Carbon::yesterday()
    ]);
    Course::factory()->create([
        'title' => 'Course B'
    ]);
    // Act and Assert

    get(route('home'))
    ->assertSeeText([
        'Course A'
    ])
    ->assertDontSee([
        'Course B'
    ]);
});

it('shows courses by release date', function (){
        // Arrage
        Course::factory()->create([
            'title' => 'Course A',
            'released_at' => Carbon::yesterday()
        ]);
        Course::factory()->create([
            'title' => 'Course B',
            'released_at' => Carbon::now()
        ]);
        // Act and Assert
    
        get(route('home'))
        ->assertSeeTextInOrder([
            'Course A',
            'Course B',
        ]);
});


