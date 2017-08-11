<?php

namespace Core\Routing;

class Route
{
    /**
     * Create new instance of the Route.
     * 
     * @param string $route
     * @param string $uri 
     * @param string $action
     * @param string|null $regexp
     */
    public function __construct($route, $uri, $action, $regexp = null)
    {
        $this->route = $route;
        $this->uri = $uri;
        $this->action = $action;
        $this->regexp = $regexp;
        $this->parameters = [];

        if ($regexp) {
            $this->bindRouteParameters();
        }
    }

    /**
     * Get action property.
     * 
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Get parameters property.
     * 
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Bind route parameters to uri values.
     * 
     * @return void
     */
    public function bindRouteParameters()
    {
        $keys = $this->defineParameterNames();
        $values = $this->defineParameterValues();

        if (count($keys) === count($values)) {
            $this->parameters = array_combine($keys, $values);
        }
    }

    /**
     * @return array
     */
    protected function defineParameterNames()
    {
        preg_match_all('/{(\w+?)}/', $this->route, $matches);

        return $matches[1];
    }

    /**
     * @return array
     */
    protected function defineParameterValues()
    {
        preg_match_all($this->regexp, $this->uri, $matches);

        if ($parametersValues = array_slice($matches, 1)) {
            return call_user_func_array('array_merge', array_slice($matches, 1));
        }

        return [];
    }
}