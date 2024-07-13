<?php

use App\Models\Course;
use Carbon\Carbon;

use function Pest\Laravel\get;

it('shows courses overview', function () {

    // Arrange
    $firstCourse = Course::factory()->released()->create();
    $secondCourse = Course::factory()->released()->create();
    $thirdCourse = Course::factory()->released()->create();

    // Act and Assert
    get(route('pages.home'))
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

    get(route('pages.home'))
        ->assertSeeText($releasedCourse->title)
        ->assertDontSee($notReleasedCoourse->title);
});

it('shows courses by release date', function () {
    // Arrage
    $releasedCourse = Course::factory()->released(Carbon::yesterday())->create();
    $newestReleasedCoourse = Course::factory()->released()->create();
    // Act and Assert

    get(route('pages.home'))
        ->assertSeeTextInOrder([
            $newestReleasedCoourse->title,
            $releasedCourse->title,
        ]);
});

it('includes login if not logged in', function () {
    // Act & Assert
    get(route('pages.home'))
        ->assertOk()
        ->assertSeeText('Login');
});

it('includes logout if logged in', function () {
    // Act & Assert
    LoginAsUser();
    get(route('pages.home'))
        ->assertOk()
        ->assertSeeText('Log out')
        ->assertSee(route('logout'));
});
