<?php

namespace Core\Routing;

class Route
{
    public function __construct($route, $uri, $action, $regexp = null)
    {
        $this->route = $route;
        $this->uri = $uri;
        $this->regexp = $regexp;
        $this->action = $action;
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

    public function bindRouteParameters()
    {
        $this->parameters = array_combine($this->defineParameterNames(), $this->defineParameterValues());
    }

    protected function defineParameterNames()
    {
        preg_match_all('/{(.+?)}/', $this->route, $matches);

        return $matches[1];
    }

    protected function defineParameterValues()
    {
        preg_match_all($this->regexp, $this->uri, $matches);

        return call_user_func_array('array_merge', array_slice($matches, 1));
    }


}