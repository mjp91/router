<?php

namespace Router;

use Router\Actions\AbstractAction;
use Router\Exceptions\RouteNotFoundException;

require_once __DIR__ . '/actions/AbstractAction.class.php';
require_once __DIR__ . '/../classes/exceptions/RouteNotFoundException.class.php';

/**
 * Holds a dictionary of routes with functions to match a request with entries
 *
 * @author Matthew Pearsall <mjp91@live.co.uk>
 *
 * Class Router
 * @package Router
 */
class Router
{
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
     * @param AbstractAction $action
     */
    public function addRoute($path, $action)
    {
        $this->routes[$this->basePath . $path] = $action;
    }

    /**
     * Retrieves a route from the dictionary by it's path definition
     *
     * @param string $path
     * @return AbstractAction
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
     * @return AbstractAction|null
     */
    public function match()
    {
        $request_method = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
        // request string before first query parameter
        $request_uri = strtok(filter_input(INPUT_SERVER, 'REQUEST_URI'), "?");

        try {
            $action = $this->getRouteByPath($request_uri);
            // check action can be induced with request method
            if (!in_array($request_method, $action->getValidHttpMethods())) {
                return null;
            }

            return $this->getRouteByPath($request_uri);
        } catch (RouteNotFoundException $ex) {
            return null;
        }
    }
}