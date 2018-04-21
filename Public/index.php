<?php
// Get the root folder and the root url of the application and set it as constant named ROOT
$path = json_decode(file_get_contents('./../Conf/Path.json'), true);
define('ROOT', $_SERVER['DOCUMENT_ROOT'] . $path['base_dir']);
define('URL', $path['base_url']);

// Start the application
require ROOT . 'vendor/autoload.php';
session_start();
$router = new Router\Router($_GET['url']);
