<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Site Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains configuration settings specific to the site.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Site Passcode
    |--------------------------------------------------------------------------
    |
    | This value is the passcode used for accessing the site when it's in
    | construction mode. This should be a secure value in production.
    |
    */
    'passcode' => env('SITE_PASSCODE', 'password'),
];
