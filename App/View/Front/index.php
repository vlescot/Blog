<?php 
// require_once './../Controller/Controller.php';

if (isset($_GET['view'])) {

	// $controller = new Controller;

	if ($_GET['view'] === 'blog') {
		require 'blog.php';
	}
	else {
		echo "ERROR";
	}
}
else {
	require 'welcome.php';
}