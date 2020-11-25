<?php

namespace YiddisheKop\UserPreferences\Facades;

use Illuminate\Support\Facades\Facade;

class UserPreferences extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'userpreferences';
    }
}
