<?php

$configs = require(base_path('configs.php'));

$db = new Database($configs['Database']);

$db->query('UPDATE flavor_tbl SET flavor_name = :namee, flavor_cost = :cost WHERE flavor_id = :id', [
  'namee' => $_POST['flavor_name'],
  'cost' => $_POST['flavor_cost'],
  'id' => $_POST['flavor_id']
]);

header('Location: /orders/flavors');