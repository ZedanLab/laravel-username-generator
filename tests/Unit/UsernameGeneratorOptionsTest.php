<?php

use ZedanLab\UsernameGenerator\Services\UsernameGeneratorOptions;
use ZedanLab\UsernameGenerator\Tests\App\Models\User;
use ZedanLab\UsernameGenerator\Tests\App\Models\UserWithoutUsername;

it('throws an exception if you give it a form that does not implement shouldGeneratesUsername', function () {
    $user = UserWithoutUsername::factory()->create();
    UsernameGeneratorOptions::get(key:'all', model:$user);
})->throws(InvalidArgumentException::class, "Model argument must implements ZedanLab\UsernameGenerator\Contracts\ShouldGeneratesUsername interface.");

it('loads the configuration from the given model if it exists', function () {
    $defaultSource = config('username-generator.source');
    expect($defaultSource)->toBeNull();

    User::setUsernameGeneratorOptions(['source' => 'email']);
    $fieldSource = UsernameGeneratorOptions::get(key:'source', model:User::class);
    expect($fieldSource == 'email')->toBeTrue();
});

it('returns all configuration options', function () {
    $options = UsernameGeneratorOptions::get(key:'all', model:User::class);
    expect(array_keys($options) == ['source', 'field', 'route_binding', 'on_creating', 'on_updating', 'unique', 'separator', 'lowercase', 'regex', 'convert_to_ascii'])->toBeTrue();

    $options = UsernameGeneratorOptions::get(key:'all');
    expect(array_keys($options) == ['source', 'field', 'route_binding', 'on_creating', 'on_updating', 'unique', 'separator', 'lowercase', 'regex', 'convert_to_ascii'])->toBeTrue();
});

it('returns the value of the given option key', function () {
    User::setUsernameGeneratorOptions(['on_updating' => false, 'source' => 'name']);

    $option = UsernameGeneratorOptions::get(key:'on_updating', model:User::class);
    expect($option == false)->toBeTrue();

    $option = UsernameGeneratorOptions::get(key:'on_updating');
    expect($option == false)->toBeTrue();
});
