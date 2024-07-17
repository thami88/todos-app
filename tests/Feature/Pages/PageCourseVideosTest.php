<?php

use App\Livewire\VideoPlayer;
use App\Models\Course;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Sequence;

use function Pest\Laravel\get;

it('cannot be access by guest', function () {
    // Arrange
    $course = Course::factory()->create();

    // Act & Assert
    get(route('page.course-videos', $course))
        ->assertRedirect(route('login'));
});

it('includes video player', function () {
    // Arrange
    $course = Course::factory()
        ->has(Video::factory())
        ->create();

    // Act & Assert
    LoginAsUser();
    get(route('page.course-videos', $course))
        ->assertOk()
        ->assertSeeLivewire(VideoPlayer::class);
});

it('shows first course video by default', function () {
    // Arrange
    $course = Course::factory()
        ->has(Video::factory()
            ->state(['title' => 'My Video']))
        ->create();
    // Act & Assert
    LoginAsUser();
    get(route('page.course-videos', $course))
        ->assertOk()
        ->assertSeeText('My Video');
});

it('shows provided course video', function () {
    // Arrange
    $course = Course::factory()
        ->has(Video::factory()
            ->state(new Sequence(
                [
                    'title' => 'First Video',
                    'title' => 'Second Video'
                ]
            ))->count(2))
        ->create();
    // Act & Assert
    LoginAsUser();
    get(route(
        'page.course-videos',
        [
            'course' => $course,
            'video' => $course->videos()->orderByDesc('id')->first()
        ]
    ))
        ->assertOk()
        ->assertSeeText('Second Video');
});
