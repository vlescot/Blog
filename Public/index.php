<?php
require './../vendor/autoload.php';
session_start();
$router = new Router\Router($_GET['url']);
