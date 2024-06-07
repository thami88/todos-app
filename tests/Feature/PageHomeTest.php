<?php

use App\Models\Course;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('shows courses overview', function () {

    // Arrange
    $firstCourse = Course::factory()->released()->create();
    $secondCourse = Course::factory()->released()->create();
    $thirdCourse = Course::factory()->released()->create();

    // Act and Assert
    get(route('home'))
     ->assertSeeText([
        $firstCourse->title,
        $firstCourse->description,
        $secondCourse->title,
        $secondCourse->description,
        $thirdCourse->title,
        $thirdCourse->description,
    ]);

});

it('shows only released courses', function () {
    // Arrage
    $releasedCourse = Course::factory()->released()->create();
    $notReleasedCoourse = Course::factory()->create();
    // Act and Assert

    get(route('home'))
    ->assertSeeText($releasedCourse->title)
    ->assertDontSee($notReleasedCoourse->title);
});

it('shows courses by release date', function (){
        // Arrage
        $releasedCourse = Course::factory()->released(Carbon::yesterday())->create();
        $newestReleasedCoourse = Course::factory()->released()->create();
        // Act and Assert
    
        get(route('home'))
        ->assertSeeTextInOrder([
            $newestReleasedCoourse->title,
            $releasedCourse->title,
        ]);
});