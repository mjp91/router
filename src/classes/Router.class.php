<?php

use Router\Actions\iAction;
use Router\Exceptions\RouteNotFoundException;

require_once __DIR__ . '/actions/iAction.class.php';
require_once __DIR__ . '/../classes/exceptions/RouteNotFoundException.class.php';

class Router
{
    private $routes = array();
    private $basePath;

    public function __construct($basePath = "/")
    {
        $this->basePath = $basePath;
    }

    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * @param string $path
     * @param iAction $action
     */
    public function addRoute($path, $action)
    {
        $this->routes[$this->basePath . $path] = $action;
    }

    /**
     * @param string $path
     * @return iAction
     * @throws RouteNotFoundException
     */
    public function getRoute($path)
    {
        if (isset($this->routes[$path])) {
            return $this->routes[$path];
        } else {
            throw new RouteNotFoundException();
        }
    }

    /**
     * @return iAction|null
     */
    public function match()
    {
        $request_uri = filter_input(INPUT_SERVER, 'REQUEST_URI');

        try {
            return $this->getRoute($request_uri);
        } catch (RouteNotFoundException $ex) {
            return null;
        }
    }
}