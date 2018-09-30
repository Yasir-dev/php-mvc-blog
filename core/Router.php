<?php

namespace core;

/**
 * Core Router class
 *
 * PHP version 7
 *
 * @author yasir khurshid <yasir.khurshid@gmail.com>
 */

class Router
{
    /**
     * Controller namespace
     */
    const CONTROLLER_NAMESPACE_PATTERN = 'app\controllers\%sController';

    /**
     * Array of routes (Routing table)
     *
     * @var array
     */
    protected $routes = array();

    /**
     * Route parameters (of matching route)
     *
     * @var array
     */
    protected $parameters = array();

    /**
     * Search patterns for routes (using named captured group)
     *
     * @var array
     */
    private $searchPatterns = array('/\//', '/\{([a-z]+)\}/', '/\{([a-z]+):([^\}]+)\}/');

    /**
     * Replacement patterns for routes (using named captured group)
     *
     * @var array
     */
    private $replacePatterns = array('\/', '(?P<\1>[a-z-]+)', '(?P<\1>\2)');


    /**
     * Add a route to the routing table
     *
     * @param string $route     Route Url
     *
     * @param array $parameters Parameters (Controller, actions)
     *
     * @return $this
     */
    public function add(string $route, array $parameters = array()): Router
    {
        $route = '/^' . preg_replace($this->searchPatterns, $this->replacePatterns, $route) . '$/i';

        $this->routes[$route] = $parameters;

        return $this;
    }

    /**
     * Dispatch the url to the corresponding controller
     *
     * @param $url
     *
     * @throws \Exception
     *
     * @return void
     */
    public function dispatch(string $url)
    {
        $url = $this->removeQueryStringVariable($url);

        if ($this->match($url)) {

            $controller = $this->getController();

            if (class_exists($controller)) {
                $controllerObject = new $controller($this->parameters);
                $action = $this->getControllerAction();

                if (preg_match('/action$/i', $action) == 0) {
                    $controllerObject->$action();
                } else {
                    throw new \Exception("Method $action in controller $controller cannot be called directly - remove the Action suffix!");
                }
            } else {
                throw new \Exception("Controller class $controller not found");
            }
        } else {
            throw new \Exception("Route $url not found.", 404);
        }
    }

    /**
     * Check if the url is in the routing table
     *
     * @param string $url Url
     *
     * @return bool
     */
    private function match(string $url): bool
    {
        foreach ($this->routes as $route => $parameters) {
            if (preg_match($route, $url, $matches)) {
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        $parameters[$key] = $match;
                    }
                }
                $this->parameters = $parameters;

                return true;
            }
        }

        return false;
    }

    /**
     * Covert string to StudlyCase (as per PSR1 naming conventions)
     *
     * Example: foo-bar => FooBar
     *
     * @param string $string String to covert
     *
     * @return string
     */
    private function convertToStudlyCaps(string $string):string
    {
        return ucwords(str_replace('-', '', $string));
    }

    /**
     * Convert to camelCase
     *
     * Example: what-is => whatIs
     *
     * @param string $string String to covert
     *
     * @return string
     */
    private function convertToCamelCase(string $string): string
    {
        return lcfirst($this->convertToStudlyCaps($string));

    }

    /**
     * Return controller namespace
     *
     * Example: app\controllers\Foo
     *
     * @return string
     */
    private function getController(): string
    {
        return \sprintf(
            self::CONTROLLER_NAMESPACE_PATTERN,
            $this->convertToStudlyCaps($this->parameters['controller'])
        );
    }

    /**
     * Return the action for the controller
     *
     * @return string
     */
    private function getControllerAction(): string
    {
        return $this->convertToCamelCase($this->parameters['action']);
    }

    /**
     * Remove query parameters from url
     *
     * @param string $url Url
     *
     * @return string
     */
    private function removeQueryStringVariable(string $url):string
    {
        $urlParts = \explode('&', $url, 2);

        if (\strpos($urlParts[0], '=') === false) {
            return $urlParts[0];
        }

        return '';
    }
}
