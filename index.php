<?php

use Router\Actions\FileIncludeAction;
use Router\Actions\SecureFileIncludeAction;
use Router\Exceptions\ActionFailedException;

require_once __DIR__ . '/src/classes/Router.class.php';
require_once __DIR__ . '/src/classes/actions/SecureAction.class.php';
require_once __DIR__ . '/src/classes/exceptions/ActionFailedException.class.php';


$_SESSION['user_id'] = "mattp";

$router = new Router("/router");

$router->addRoute("/", new FileIncludeAction('home.php'));
$router->addRoute("/about", new SecureFileIncludeAction('about.php'));

$matchAction = $router->match();

if (isset($matchAction)) {
    try {
        $matchAction->doAction();
    } catch (ActionFailedException $ex) {
        http_response_code(403);
        echo "<h1>Action failed</h1>";
    }
} else {
    http_response_code(404);
    echo $_SERVER['REQUEST_URI'] . "<br/>";
    print_r($router->getRoutes());
    echo "<h1>404 Not found</h1>";
}

