<?php

use App\Livewire\VideoPlayer;
use App\Models\Course;
use App\Models\Video;
use Livewire\Livewire;

use function Pest\Laravel\get;

it('shows details for given video', function () {
    // Arrange
    $course = Course::factory()
        ->has(Video::factory()
            ->state(
                [
                    'title' => 'Video title',
                    'description' => 'Video Description',
                    'duration' => 10
                ]
            ))
        ->create();

    // Act & Assert
    Livewire::test(
        VideoPlayer::class,
        [
            'video' => $course->videos->first()
        ]
    )->assertSeeText(
        [
            'Video title',
            'Video Description',
            '10 min'
        ]
    );
});

it('shows given video', function () {
    // Arrange
    $course = Course::factory()
        ->has(Video::factory()
            ->state(
                [
                    'vimeo_id' => 'vimeo-id',
                ]
            ))
        ->create();
    // Act $ Assert
    Livewire::test(
        VideoPlayer::class,
        [
            'video' => $course->videos->first()
        ]
    )->assertSee('<iframe src="https://player.vimeo.com/video/vimeo-id"', false);
});
