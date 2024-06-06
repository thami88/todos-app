<?php

use function Pest\Laravel\get;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);


it('gives back successful response for home page', function () {
    // Act & Assert
    get(route('home'))->assertOk();
});
