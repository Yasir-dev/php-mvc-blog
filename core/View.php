<?php

namespace core;

/**
 * Core view class
 *
 * PHP version 7
 *
 * @author yasir khurshid <yasir.khurshid@gmail.com>
 */
class View
{
    /**
     * Template engine
     *
     * @var null
     */
    private static $twig = null;

    /**
     * Render a template for view via twig template engine
     *
     * @param string $template Template
     * @param array $data      Data
     *
     * @return void
     */
    public static function renderTemplate(string $template, array $data = array())
    {
        if (null === self::$twig) {
            $loader = new \Twig_Loader_Filesystem(dirname(__DIR__) . '/app/views');
            self::$twig   = new \Twig_Environment($loader);
        }

        echo self::$twig->render($template, $data);
    }
}