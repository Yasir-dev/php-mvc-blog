<?php

namespace app;

/**
 * Session class - To manage user sessions
 *
 * PHP version 7
 *
 * @author yasir khurshid <yasir.khurshid@gmail.com>
 */
class Session
{
    /**
     * Session constructor.
     */
    public function __construct()
    {
        \session_start();
    }

    /**
     * Set session value
     *
     * @param string $name  Name
     * @param mixed  $value Values
     *
     * @return $this
     */
    public function set($name, $value)
    {
        $_SESSION[$name] = $value;

        return $this;
    }

    /**
     * Return value from session
     *
     * @param string $name Name
     *
     * @return mixed
     */
    public function get($name)
    {
        if (isset($_SESSION[$name])) {
            return $_SESSION[$name];
        }

        return false;
    }

    /**
     * Destroy the session
     */
    public function destroy()
    {
        \session_destroy();
    }
}