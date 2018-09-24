<?php

/**
 * Front controller
 *
 * This handles all incoming requests and pass to the router which decide about the correspoding controller
 *
 * @author yasir khurshid <yasir.khurshid@gmail.com>
 */

/**
 * Composer autoloader
 */
require '../vendor/autoload.php';

/**
 * Error Handler
 */
error_reporting(E_ALL);
set_error_handler('core\ErrorHandler::handleError');
set_exception_handler('core\ErrorHandler::handleException');

/**
 * Routing
 */
$router = new core\Router();

$router->add('', ['controller' => 'Home', 'action' => 'index'])
    ->add('{controller}/{action}')
    ->add('{controller}/{id:\d+}/{action}')
    ->dispatch((new \app\Request())->getQueryString());
