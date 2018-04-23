<?php
namespace Router;

/**
 * This class get the routes and checks if the URL matches with
 */
class Router
{
    /** @var string $_url contains current URL */
    private $_url;
    /** @var array $_routes contains the Route objects */
    private $_routes = [];

    public function __construct($url)
    {
        $this->_url = $url;
        $routes = json_decode(file_get_contents(ROOT . 'App/Router/Routes.json'), true);
        foreach ($routes as $value) {
            $this->addRoute($value['path'], $value['callable'], $value['method']);
        }
        $this->run();
    }

    /**
     * Adding route to the attribut $_routes
     * @param string $path     full path of the route
     * @param string $callable Controller#Method
     * @param string $method   GET or POST
     */
    private function addRoute($path, $callable, $method)
    {
        $this->_routes[$method][] = new Route($path, $callable);
    }


    /**
     * Checks if the request method exists if yes, runs the match for each routes
     * @return the calling method from the good controller
     */
    private function run()
    {
        if (!isset($this->_routes[$_SERVER['REQUEST_METHOD']])) {
            throw new Exception('REQUEST_METHOD does not exists');
        }

        foreach ($this->_routes[$_SERVER['REQUEST_METHOD']] as $route) {
            if ($route->match($this->_url)) {
                return $route->call();
            }
        }
        // If no route matches
        header('Location: ' . URL . '404');
    }
}
