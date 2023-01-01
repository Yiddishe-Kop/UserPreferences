<?php

namespace YiddisheKop\UserPreferences;

class Support
{
    public static function getTable()
    {
        if ($model = config('user-preferences.model')) {
            return (new $model)->getTable();
        }

        return config('user-preferences.database.table');
    }
}
