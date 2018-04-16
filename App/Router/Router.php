<?php
namespace Router;

class Router 
{
	private $_url,
			$_routes = [];

	function __construct ($url)
	{
		$this->_url = $url;
		$routes = json_decode (file_get_contents(__DIR__ . '\routes.json'), true);	
		foreach ($routes as $key => $value) {
			$this->addRoute($value['path'], $value['callable'], $value['method']);
		}
		$this->run();
	}

	private function addRoute ($path, $callable, $method)
	{
		$this->_routes[$method][] = new Route($path, $callable);
	}


	/**
	 * Checks if the request method exists if yes, runs the match for each routes
	 * @return the calling method from the good controller
	 */
	private function run ()
	{
		if (!isset($this->_routes[$_SERVER['REQUEST_METHOD']])) {
			throw new Exception ('REQUEST_METHOD does not exists');
		}

		foreach ($this->_routes[$_SERVER['REQUEST_METHOD']] as $route) {
			if ($route->match($this->_url)) {
				return $route->call();
			}
		}
		// If no route matches
		header ('Location: http://localhost/P5/Blog/404');
	}
}