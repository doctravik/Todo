<?php

namespace Core;

use Core\Container;
use Core\Exceptions\RouteNotFoundException;

class Router
{
    /**
     * @var array
     */
    private $routes;

    public function __construct($file)
    {
        $this->routes['GET'] = [];
        $this->routes['POST'] = [];

        $this->loadRoutesFrom($file);
    }

    /**
     * Load map of routes.
     * 
     * @param  string $filepath
     * @return void
     */
    private function loadRoutesFrom($filepath)
    {
        $router = $this;

        require_once($filepath);
    }

    /**
     * Register a GET route.
     *
     * @param string $uri
     * @param string $action
     */
    public function get($uri, $action) {
        $this->routes['GET'][$uri] = $action;
    }

    /**
     * Register a POST route.
     *
     * @param string $uri
     * @param string $action
     */
    public function post($uri, $action) {
        $this->routes['POST'][$uri] = $action;
    }

   /**
     * Route to uri.
     *
     * @param string $uri
     * @param string $method
     * @return void
     */
    public function direct($uri, $method)
    {
        if (! array_key_exists($uri, $this->routes[$method])) {
            throw new RouteNotFoundException("Route isn't defined");
        } 

        [$controller, $action] = explode('@', $this->routes[$method][$uri]);

        return $this->callAction($controller, $action);
    }

    /**
     * Call action of the controller.
     * 
     * @param  string $controller
     * @param  string $action
     * @return void  
     */
    public function callAction($controller, $action)
    {
        $controller = "App\\Controllers\\{$controller}";

        if (! class_exists($controller)) {
            throw new RouteNotFoundException("Unable to load class: $controller");
        }

        if (! method_exists($controller = new $controller, $action)) {
            throw new RouteNotFoundException(
                "Controller " . get_class($controller) . " has no action: $action"
            );
        }

        return $controller->$action();
    }
}