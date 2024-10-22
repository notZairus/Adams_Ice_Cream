<?php


$configs = require(base_path('configs.php'));

$db = new Database($configs['Database']);

$db->query('INSERT INTO flavor_tbl (flavor_name, flavor_cost) VALUES (:namee, :cost)', [
  'namee' => $_POST['flavor_name'],
  'cost' => $_POST['flavor_cost']
]);

header('Location: /orders/flavors');