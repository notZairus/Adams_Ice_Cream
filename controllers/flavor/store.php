<?php


$configs = require(base_path('configs.php'));

$db = new Database($configs['Database']);

$db->query('INSERT INTO flavor_tbl (flavor_name, flavor_cost, flavor_order_count) VALUES (:namee, :cost, :foc)', [
  'namee' => $_POST['flavor_name'],
  'cost' => $_POST['flavor_cost'],
  'foc' => 0
]);




header('Location: /flavors');