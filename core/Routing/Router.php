<?php

namespace Core\Routing;

use Core\Container;
use Core\Routing\RouteCompiler;
use Core\Exceptions\RouteNotFoundException;

class Router
{
    /**
     * @var array
     */
    protected $routes;

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
    protected function loadRoutesFrom($filepath)
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
     * @return Core\Http\Response
     */
    public function direct($uri, $method)
    {
        $routes = $this->routes[$method];

        if ($route = $this->findRoute($uri, $routes)) {
            return $this->getResponse($route, $routes[$route]);
        }

        throw new RouteNotFoundException("Route isn't defined");
    }

    /**
     * Find route for the given uri of the web request.
     * 
     * @param  string $uri
     * @param  array $routes
     * @return string|null
     */
    protected function findRoute($uri, array $routes) 
    {
        if ($this->matchAgainstRoutes($uri, $routes)) {
            return $uri;
        }

        return $this->checkRoutesConsiderWildcard($uri, $routes);
    }

    /**
     * Check if there are route that exactly matches uri of the web request.
     * 
     * @param  string $uri
     * @param  array $routes
     * @return boolean
     */
    protected function matchAgainstRoutes($uri, array $routes) {
        return array_key_exists($uri, $routes);
    }

    /**
     * Check if the routes with wildcards matches uri of the web request.
     * 
     * @param  string $uri
     * @param  array $routes
     * @return string|null
     */
    protected function checkRoutesConsiderWildcard($uri, array $routes) {
        foreach ($routes as $route => $action) {
            if ($this->matches($route, $uri)) {
                return $route;
            }
        }

        return null;
    }

    /**
     * Check if the regexp version of the route matches uri of the web request.
     * 
     * @param  string $route
     * @param  string $uri
     * @return boolean
     */
    protected function matches($route, $uri) 
    {
        return preg_match(RouteCompiler::getRegexp($route), $uri);
    }

    /**
     * Retrieve web response after processing action.
     * 
     * @param  string $route
     * @param  string $action
     * @return Core\Http\Response
     */
    protected function getResponse($route, $action)
    {
        return $this->callAction(...explode('@', $action));
    }

    /**
     * Call action of the controller.
     * 
     * @param  string $controller
     * @param  string $action
     * @return Core\Http\Response 
     */
    protected function callAction($controller, $action)
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