<?php

namespace Core;

use Core\Router;
use Core\Container;
use Core\Http\Request;
use Core\Http\Response;
use Core\Database\Connection;
use Core\Exceptions\RouteNotFoundException;

class App
{
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function getContainer()
    {
        return $this->container;
    }
    
    /**
     * Run application.
     * 
     * @return void
     */
    public function run()
    {
        $this->container['db'] = new Connection($this->container['config']['database']);
        $request = $this->container['request'] = new Request;
        $router = $this->container['router'] = new Router($this->container['config']['routes']);
        $response = $this->container['response'] = new Response;

        try {
            $router->direct(parse_url($request->uri(), PHP_URL_PATH), $request->method());
        } catch (RouteNotFoundException $e) {
            die($e->getMessage());
        }
    }
}