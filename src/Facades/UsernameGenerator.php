<?php

namespace ZedanLab\UsernameGenerator\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \ZedanLab\UsernameGenerator\UsernameGenerator
 */
class UsernameGenerator extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-username-generator';
    }
}
