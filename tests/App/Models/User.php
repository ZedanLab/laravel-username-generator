<?php

namespace ZedanLab\UsernameGenerator\Tests\App\Models;

use ZedanLab\UsernameGenerator\Traits\HasUsername;
use ZedanLab\UsernameGenerator\Contracts\ShouldGeneratesUsername;
use ZedanLab\UsernameGenerator\Tests\Database\Factories\UserFactory;

class User extends UserWithoutUsername implements ShouldGeneratesUsername
{
    use HasUsername;

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory<static>
     */
    protected static function newFactory()
    {
        return UserFactory::new ();
    }

    /**
     * Setup the Username Generator default options.
     *
     * @return array
     */
    public static function defaultUsernameGeneratorOptions(): array
    {
        return [
            'source' => 'email',
            'field'  => 'username',
        ];
    }
}
