<?php

namespace app;

/**
 * App configuration
 *
 * PHP version 7
 *
 * @author yasir khurshid <yasir.khurshid@gmail.com>
 */
class AppConfig
{
    /**
     * Database host
     */
    const DB_HOST = 'localhost';

    /**
     * Database name
     */
    const DB_NAME = 'MVC';

    /**
     * Database username
     */
    const DB_USERNAME = 'yasir';

    /**
     * Database password
     */
    const DB_PASSWORD = '4rjgOHUmCLEyyMrK';

    /**
     * Flag to show/hide errors
     */
    const DISPLAY_ERRORS = true;

    /**
     * Salt for password
     */
    const USER_PASSWORD_SALT = 'WhatTheHellIsThisPasswordThing';
}
