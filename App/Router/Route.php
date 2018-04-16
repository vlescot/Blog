<?php
namespace Router;

class Route
{
	private $_path,
			$_callable,
			$_matches = [],
			$_params = [];

	function __construct ($path, $callable)
	{
		$this->_path = trim($path, '/');
		$this->_callable = $callable;
	}

	/**
	 * Checks if the URL is corresponding with a route and extracts variable into.
	 * @return true if the URL matches
	 * @return false if the URL doesn't matches
	 */
	function match ($url)
	{
		$url = trim($url, '/'); // Removes "/" at the beginning and ending URL's string
		$path = preg_replace('#:([\w]+)#', '([0-9]+)', $this->_path); // Replaces variable (after :) into the URL to allow regex
		$regex = "#^$path$#i"; 
		if (!preg_match($regex, $url, $matches)) {// Checks if the URL is matching with the path
			return false;
		}
		array_shift($matches);
		$this->_matches = $matches;
		return true;
	}

	/**
	 * Calls the corresponding method from the good controller and set the parameters
	 * @return the value from the calling method
	 */
	function call ()
	{
		$params = explode('#', $this->_callable);
		$controller = "Controller\\" . $params[0] . "Controller";
		$controller = new $controller($params[0]);
		return call_user_func_array([$controller, $params[1]], $this->_matches);
	}
}
