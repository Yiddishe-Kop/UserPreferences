<?php

return [

    'model'    => null,

    // Database
    'database' => [
        'table'       => 'users',
        'column'      => 'preferences',
        'primary_key' => 'id',
    ],

    // Default preferences
    'defaults' => [
        'theme' => 'dark',
    ],

];
