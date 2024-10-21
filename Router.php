<?php

class Router {
  protected $routes = [];

  public function get($uri, $controller) {
    $this->routes[] = [
      'uri' => $uri,
      'controller' => $controller,
      'method' => 'GET'
    ];
  }

  public function post($uri, $controller) {
    $this->routes[] = [
      'uri' => $uri,
      'controller' => $controller,
      'method' => 'POST'
    ];
  }

  public function delete($uri, $controller) {
    $this->routes[] = [
      'uri' => $uri,
      'controller' => $controller,
      'method' => 'DELETE'
    ];
  }

  public function patch($uri, $controller) {
    $this->routes[] = [
      'uri' => $uri,
      'controller' => $controller,
      'method' => 'PATCH'
    ];
  }

  public function route($uri) {
    $method = isset($_POST['_method']) ? $_POST['_method'] : $_SERVER['REQUEST_METHOD'];

    foreach ($this->routes as $route) {
      if ($route['uri'] == $uri && $route['method'] == $method) {
        return require(base_path($route['controller']));
      }
    }
  }
}