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
     * PostController request method
     */
    const METHOD_POST = 'post';

    /**
     * Get request method
     */
    const METHOD_GET = 'get';

    /**
     * Return the request parameter
     *
     * @param string $parameter           Parameter
     * @param bool   $convertSpecialChars Special chars flag
     * @param string $method              Request method
     *
     * @return mixed
     */
    public static function get($parameter, $convertSpecialChars = false, $method = self::METHOD_POST)
    {
        $value = self::getParameter($parameter, $method);

        if (true === $convertSpecialChars) {
            return \htmlentities($value);
        }

        return filter_var($value, FILTER_SANITIZE_STRING);
    }

    /**
     * Return query string
     *
     * @return mixed
     */
    public static function getQueryString()
    {
        return $_SERVER['QUERY_STRING'];
    }

    /**
     * Return parameter value based on the request method
     *
     * @param string $parameter Parameter
     * @param string $method    Special chars flag
     *
     * @return mixed
     */
    private static function getParameter(string $parameter, string $method)
    {
        if ($method === self::METHOD_POST) {
            return $_POST[$parameter];
        }

        return $_GET[$parameter];
    }
}
