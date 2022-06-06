<?php

use Illuminate\Support\Str;
use ZedanLab\UsernameGenerator\Tests\App\Models\User;

it('generates a username on creating if it is enabled', function () {
    User::setUsernameGeneratorOptions(['on_creating' => true]);

    $user = User::factory()->create();
    expect(!is_null($user->username))->toBeTrue();
});

it('generates a unique username on creating', function () {
    User::setUsernameGeneratorOptions(['on_creating' => true, 'unique' => true, 'source' => 'name']);

    $user = User::factory()->create(['name' => 'John Doe']);
    $anotherUser = User::factory()->create(['name' => 'John Doe']);

    expect($user->username != $anotherUser->username)->toBeTrue();
    expect(Str::startsWith($anotherUser->username, $user->username))->toBeTrue();
});

// it('generates a username on updating if it is enabled', function () {
//     User::setUsernameGeneratorOptions(['on_updating' => true, 'source' => 'name']);

//     $user = User::factory()->create(['name' => 'John']);
//     $oldUsername = $user->username;

//     $user->update(['name' => 'Doe']);
//     $newUsername = $user->username;

//     expect($oldUsername !== $newUsername)->toBeTrue();
// });

// it('not generates a username on updating if it is disabled', function () {
//     User::setUsernameGeneratorOptions(['on_updating' => false]);

//     $user = User::factory()->create(['name' => 'John']);
//     $oldUsername = $user->username;

//     $user->update(['name' => 'Doe']);
//     $newUsername = $user->username;

//     expect($oldUsername == $newUsername)->toBeTrue();
// });
