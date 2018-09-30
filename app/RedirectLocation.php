<?php

namespace app;

/**
 * Redirect location class - To redirect to a particular location
 *
 * PHP version 7
 *
 * @author yasir khurshid <yasir.khurshid@gmail.com>
 */
class RedirectLocation
{
    /**
     * Redirect to a location
     *
     * @param string $location Location
     */
    public static function redirect(string $location)
    {
        \header('Location: '.$location);
    }
}
