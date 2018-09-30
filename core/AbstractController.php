<?php

namespace core;

use app\Session;

/**
 * Core controller class
 *
 * PHP version 7
 *
 * @author yasir khurshid <yasir.khurshid@gmail.com>
 */
abstract class AbstractController
{
    /**
     * @var Session
     */
    protected $session;

    /**
     * Parameters of a route
     *
     * @var array
     */
    protected $routeParameters = array();

    /**
     * AbstractController constructor.
     *
     * @param array $routeParameters Route parameters
     */
    public function __construct(array $routeParameters)
    {
        $this->routeParameters = $routeParameters;
        $this->session = new Session();
    }

    /**
     * Magic call method (this can also be used for action filters like before and after)
     *
     * @param string $name      Method Name
     * @param array  $arguments Method arguments
     *
     * @throws \Exception
     */
    public function __call(string $name, array $arguments)
    {
        $method = \sprintf('%sAction', $name);

        if (\method_exists($this, $method)) {
            \call_user_func_array([$this, $method], $arguments);
            return;
        }

        throw new \Exception("Method $method not found in contoller ".\get_class($this));
    }

    /**
     * Before action filter - called before action method
     *
     * @return void
     */
    protected function beforeActionFilter()
    {
        //TODO implement this method to use any filter before action
    }

    /**
     * After action filter - called after action method
     *
     * @return void
     */
    protected function afterActionFiler()
    {
        //TODO implement this method to use any filter after action
    }
}
