<?php

use Illuminate\Support\Str;
use ZedanLab\UsernameGenerator\Tests\App\Models\User;

it('generates a username on updating if it is enabled', function () {
    User::setUsernameGeneratorOptions(['on_updating' => true, 'source' => 'name']);

    $user = User::factory()->create(['name' => 'John']);
    $oldUsername = $user->username;

    $user->update(['name' => 'Doe']);
    $newUsername = $user->username;

    expect($oldUsername !== $newUsername)->toBeTrue();
});

it('not generates a username on updating if it is disabled', function () {
    User::setUsernameGeneratorOptions(['on_updating' => false]);

    $user = User::factory()->create(['name' => 'John']);
    $oldUsername = $user->username;

    $user->update(['name' => 'Doe']);
    $newUsername = $user->username;

    expect($oldUsername == $newUsername)->toBeTrue();
});
