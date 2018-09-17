<?php

namespace app;

/**
 * Request class - To get parameters from http requests
 *
 * PHP version 7
 *
 * @author yasir khurshid <yasir.khurshid@gmail.com>
 */
class Request
{
    /**
     * Return the request parameter
     *
     * @param string $parameter           Parameter
     * @param bool   $convertSpecialChars Special chars flag
     *
     * @return mixed
     */
    public function get($parameter, $convertSpecialChars = false)
    {
        if (true === $convertSpecialChars) {
            return \htmlentities($_POST[$parameter]);
        }

        return filter_var($_POST[$parameter], FILTER_SANITIZE_STRING);
    }
}