<?php

use ZedanLab\UsernameGenerator\Services\UsernameGeneratorOptions;
use ZedanLab\UsernameGenerator\Tests\App\Models\User;
use ZedanLab\UsernameGenerator\Tests\App\Models\UserWithoutUsername;

it('throws an exception if you give it a form that does not implement shouldGeneratesUsername', function () {
    $user = UserWithoutUsername::factory()->create();
    UsernameGeneratorOptions::get(key:'all', model:$user);
})->throws(InvalidArgumentException::class, "Model argument must implements ZedanLab\UsernameGenerator\Contracts\ShouldGeneratesUsername interface.");

it('throws an exception if you are trying to get an unknown key name', function () {
    UsernameGeneratorOptions::get(key:'source');
})->throws(InvalidArgumentException::class, "'source' must be in [string,array,Closure], 'null => NULL' given.");

it('loads the configuration from the given model if it exists', function () {
    $defaultSource = config('username-generator.source');
    expect($defaultSource)->toBeNull();

    $user = User::factory()->create();

    $fieldSource = UsernameGeneratorOptions::get(key:'source', model:$user);
    expect($fieldSource == 'email')->toBeTrue();
});

it('returns all configuration options', function () {
    $user = User::factory()->create();
    $options = UsernameGeneratorOptions::get(key:'all', model:$user);
    expect(array_keys($options) == ['source', 'field', 'route_binding', 'on_creating', 'on_updating', 'unique', 'separator', 'lowercase', 'regex', 'convert_to_ascii'])->toBeTrue();

    $options = UsernameGeneratorOptions::get(key:'all');
    expect(array_keys($options) == ['source', 'field', 'route_binding', 'on_creating', 'on_updating', 'unique', 'separator', 'lowercase', 'regex', 'convert_to_ascii'])->toBeTrue();
});

it('returns the value of the given option key', function () {
    $user = User::factory()->create();
    $option = UsernameGeneratorOptions::get(key:'on_updating', model:$user);
    dd($option);
    expect($option == false)->toBeTrue();

    $option = UsernameGeneratorOptions::get(key:'on_updating');
    expect($option == false)->toBeTrue();
});

it('generates a username on creating', function () {
    $user = User::factory()->create();

    expect(! is_null($user->username))->toBeTrue();
});

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
