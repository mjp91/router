<?php

use Router\Actions\AbstractAction;
use Router\Exceptions\RouteNotFoundException;

require_once __DIR__ . '/actions/AbstractAction.class.php';
require_once __DIR__ . '/../classes/exceptions/RouteNotFoundException.class.php';

class Router
{
    private $routes = array();
    private $basePath;

    public function __construct($basePath = "/")
    {
        $this->basePath = $basePath;
    }

    /**
     * @param string $path
     * @param AbstractAction $action
     */
    public function addRoute($path, $action)
    {
        $this->routes[$this->basePath . $path] = $action;
    }

    /**
     * @param string $path
     * @return AbstractAction
     * @throws RouteNotFoundException
     */
    public function getRouteByPath($path)
    {
        if (isset($this->routes[$path])) {
            return $this->routes[$path];
        } else {
            throw new RouteNotFoundException();
        }
    }

    /**
     * @return AbstractAction|null
     */
    public function match()
    {
        $request_method = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
        $request_uri = filter_input(INPUT_SERVER, 'REQUEST_URI');

        try {
            $action = $this->getRouteByPath($request_uri);
            if (!in_array($request_method, $action->getValidHttpMethods())) {
                return null;
            }

            return $this->getRouteByPath($request_uri);
        } catch (RouteNotFoundException $ex) {
            return null;
        }
    }
}