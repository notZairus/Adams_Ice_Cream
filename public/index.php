<?php

require('../vendor/autoload.php');
require('../functions.php');

spl_autoload_register(function($class) {
  if (file_exists(base_path("{$class}.php"))) {
    return require (base_path("{$class}.php"));
  }
});



$router = new Router();

require(base_path('routes.php'));

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

$router->route($uri);