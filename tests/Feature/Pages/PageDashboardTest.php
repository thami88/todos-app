<?php

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Support\Carbon;

use function Pest\Laravel\get;

it('cannot be accessed by guest', function () {
    get(route('pages.dashboard'))
        ->assertRedirect(route('login'));
});

it('lists purchase courses', function () {
    // Arrange
    $user = User::factory()
        ->has(Course::factory()->count(2)->state(
            new Sequence(
                ['title' => 'Course A'],
                ['title' => 'Course B'],
            )
        ))
        ->create();
    // Act & Assert
    LoginAsUser($user);
    get(route('pages.dashboard'))
        ->assertOk()
        ->assertSeeText(
            'Course A',
            'Course B'
        );
});

it('does not list other courses', function () {
    //Arrange
    $course = Course::factory()->create();

    // Act & Assert
    LoginAsUser();
    get(route('pages.dashboard'))
        ->assertOk()
        ->assertDontSeeText($course->title);
});

it('shows latest purchased course first', function () {
    // Arrange
    $user = User::factory()->create();
    $firstPurchasedCourse = Course::factory()->create();
    $lastPurchasedCourse = Course::factory()->create();

    $user->courses()->attach($firstPurchasedCourse, ['created_at' => Carbon::yesterday()]); // attach course to a user
    $user->courses()->attach($lastPurchasedCourse, ['created_at' => Carbon::now()]);

    // Act & Assert
    LoginAsUser($user);
    get(route('pages.dashboard'))
        ->assertOk()
        ->assertSeeInOrder(
            [
                $lastPurchasedCourse->title,
                $firstPurchasedCourse->title,
            ]
        );
});

it('includes link to product videos', function () {
    // Arrange
    $user = User::factory()
        ->has(Course::factory())
        ->create();

    // Act & Assert
    LoginAsUser($user);
    get(route('pages.dashboard'))
        ->assertOk()
        ->assertSeeText('Watch Videos')
        ->assertSee(route('page.course-videos', Course::first()));
});
