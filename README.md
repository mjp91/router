# mjp91/router
This is a work in progress routing solution for PHP 5.3+ that aims to link RESTful HTTP requests to 'Actions'. An Action 
is a class which implements the iAction interface, all implementers must provide a 'doAction' method, an instance of an 
implementing class is then mapped to a particular route and it's doAction method instigated via HTTP. Inspired by AltoRouter.

```php
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
```

## Composer

```json
"require": {
    "mjp91/router": "dev-master"
}
```