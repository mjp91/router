<?php

/**
 * Example use of router, all requests are redirected to index.php and serviced
 */

use Router\Router;
use Router\Actions\AbstractAction;
use Router\Actions\FileIncludeAction;
use Router\Actions\SecureFileIncludeAction;
use Router\Exceptions\SecureActionFailedException;
use Router\Exceptions\ActionFailedException;

require_once __DIR__ . '/src/classes/Router.class.php';
require_once __DIR__ . '/src/classes/actions/AbstractAction.class.php';
require_once __DIR__ . '/src/classes/actions/FileIncludeAction.class.php';
require_once __DIR__ . '/src/classes/actions/SecureFileIncludeAction.class.php';
require_once __DIR__ . '/src/classes/exceptions/ActionFailedException.class.php';
require_once __DIR__ . '/src/classes/exceptions/SecureActionFailedException.class.php';


$_SESSION['user_id'] = "matt";

$router = new Router("/router");

$router->addRoute("/", new FileIncludeAction('examples/home.php', array(AbstractAction::GET)));
$router->addRoute("/about", new SecureFileIncludeAction('examples/about.php', array(AbstractAction::GET, AbstractAction::POST)));

$matchAction = $router->match();

if (isset($matchAction)) {
    try {
        $matchAction->doAction();
    } catch (SecureActionFailedException $ex) {
        http_response_code(403);
        echo $ex->getMessage();
    } catch (ActionFailedException $ex) {
        http_response_code(500);
        echo $ex->getMessage();
    }
} else {
    http_response_code(404);
    echo $_SERVER['REQUEST_URI'] . "<br/>";
    echo "<h1>404 Not found</h1>";
}

