<?php

/**
 * Example use of router, all requests are redirected to index.php and serviced
 */

use router\Router;
use exceptions\ControllerNotFound;
use exceptions\ActionNotFoundException;
use exceptions\NotAuthenticatedException;

require_once __DIR__ . '/src/autoload.php';

define("CONTROLLER_NS", "Controller\\");

$router = new Router("/router");

// Controller = DefaultController, Action = doAction
$router->addRoute("/", 'default#do', [Router::GET]);

$matchAction = $router->match();

if (isset($matchAction)) {
    $action_array = explode("#", $matchAction['action']);
    $controller_str = CONTROLLER_NS . ucfirst($action_array[0]) . 'Controller';
    $action_str = $action_array[1] . 'Action';

    try {
        if (class_exists($controller_str)) {
            $controller = new $controller_str();
            if (method_exists($controller, $action_str)) {
                $controller->$action_str();
            } else {
                throw new ActionNotFoundException();
            }
        } else {
            throw new ControllerNotFound();
        }
    } catch (ControllerNotFound $ex) {
        http_response_code(500);
        echo "Controller not found";
        exit();
    } catch (ActionNotFoundException $ex) {
        http_response_code(500);
        echo "Action not found";
        exit();
    } catch (NotAuthenticatedException $ex) {
        http_response_code(403);
        echo "Not authenticated";
        exit();
    }
} else {
    http_response_code(404);
    echo $_SERVER['REQUEST_URI'] . "<br/>";
    echo "<h1>404 Not found</h1>";
}

