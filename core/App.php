<?php

namespace Core;

use Core\Container;
use Core\Http\Request;
use Core\Http\Response;
use Core\Routing\Router;
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
        $this->container['db'] = (new Connection($this->container['config']['database']))->make();
        $request = $this->container['request'] = new Request;
        $router = $this->container['router'] = new Router($this->container['config']['routes']);
        $response = $this->container['response'] = new Response;
        
        try {
            $response = $router->direct(parse_url($request->uri(), PHP_URL_PATH), $request->method());
        } catch (RouteNotFoundException $e) {
            $response = (new Response('Page not found'))->withStatus(404);
        }
        
        return $this->process($response);
    }

    /**
     * Process web response.
     * 
     * @param  mixed $response
     * @return mixed
     */
    protected function process($response)
    {
        if (!$response instanceof Response) {
            echo $response;
            return;
        }

        header(sprintf(
            'HTTP/%s %s %s',
            '1.1',
            $response->getStatusCode(),
            ''
        ));

        foreach ($response->getHeaders() as $header) {
            header($header[0] . ': ' . $header[1]);
        }

        echo $response->getContent();
    }
}