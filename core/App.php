<?php

namespace Core;

use Core\Container;
use Core\Http\Request;
use Core\Database\Connection;

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
        $dbConnection = new Connection($this->container['config']['database']);

        $this->container['db'] = $dbConnection->make();
        $this->container['request'] = new Request;
        var_dump($this->container['request']->input('nam'));
        // $this->container['response'] = new Response;
        // $this->container['router'] = new Router;
    }
}