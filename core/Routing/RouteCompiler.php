<?php

namespace Core\Routing;

class RouteCompiler
{
    /**
     * Compile route to the regexp pattern.
     * Replace wildcard {...} with equivalent without curly braces.
     * Replace '/' with '\/' as valid regexp;
     *
     * @param  string $route
     * @return string
     */
    public static function getRegexp($route)
    {
        $routeAsRegexp = preg_replace(['/{(\w+?)}/', '/\//'], ['(\w+)', '\/'], $route);

        return "/^$routeAsRegexp\/?$/";
    }
}
