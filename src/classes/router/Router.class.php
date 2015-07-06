<?php

namespace router;

use exceptions\RouteNotFoundException;


/**
 * Holds a dictionary of routes with functions to match a request with entries
 *
 * @author Matthew Pearsall <mjp91@live.co.uk>
 *
 * Class Router
 * @package router
 */
class Router
{
    const GET = 'GET';
    const POST = 'POST';
    const PUT = 'PUT';
    const DELETE = 'DELETE';

    private $routes = array();
    private $basePath;

    public function __construct($basePath = "/")
    {
        $this->basePath = $basePath;
    }

    /**
     * Adds a route to the dictionary
     *
     * @param string $path
     * @param string $action
     * @param array $validHTTPMethods
     */
    public function addRoute($path, $action, $validHTTPMethods)
    {
        $this->routes[$this->basePath . $path]['action'] = $action;
        $this->routes[$this->basePath . $path]['methods'] = $validHTTPMethods;
    }

    /**
     * Retrieves a route from the dictionary by it's path definition
     *
     * @param string $path
     * @return string
     * @throws RouteNotFoundException
     */
    private function getRouteByPath($path)
    {
        if (isset($this->routes[$path])) {
            return $this->routes[$path];
        } else {
            throw new RouteNotFoundException();
        }
    }

    /**
     * Attempts to match the current request with a route in the dictionary
     *
     * @return array|null
     */
    public function match()
    {
        $request_method = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
        // request string before first query parameter
        $request_uri = strtok(filter_input(INPUT_SERVER, 'REQUEST_URI'), "?");

        try {
            $route = $this->getRouteByPath($request_uri);
            // check action can be induced with request method
            if (!in_array($request_method, $route['methods'])) {
                return null;
            }

            return $route;
        } catch (RouteNotFoundException $ex) {
            return null;
        }
    }
}