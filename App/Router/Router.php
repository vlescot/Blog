<?php
namespace Router;

class Router 
{
	private $url,
			$routes = [];

	function __construct ($url)
	{
		$this->url = $url;
		$routes = json_decode (file_get_contents(__DIR__ . '\routes.json'), true);	
		foreach ($routes as $key => $value) {
			$this->addRoute($value['path'], $value['callable'], $value['method']);
		}
		$this->run();
	}

	private function addRoute ($path, $callable, $method)
	{
		$this->routes[$method][] = new Route($path, $callable);
	}


	/**
	 * Checks if the request method exists if yes, runs the match for each routes
	 * @return the calling method from the good controller
	 */
	private function run ()
	{
		if (!isset($this->routes[$_SERVER['REQUEST_METHOD']])) {
			throw new RouterException ('REQUEST_METHOD does not exists');
		}

		foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $route) {
			if ($route->match($this->url)) {
				return $route->call();
			}
		}
		throw new RouterException ('No matching routes');
	}
}