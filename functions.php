<?php

function dd($data) {
  echo "<pre>";
  var_dump($data);
  echo "</pre>";
  die();
}

function base_path($path) {
  return __DIR__ . '\\' .$path;
}

function view($path, $data = []) {
  extract($data);

  return require(base_path('views\\' . $path));
}

function currentUrl($url) {
  return $_SERVER['REQUEST_URI'] == $url;
}