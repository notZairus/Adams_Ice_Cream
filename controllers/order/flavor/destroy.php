<?php

$configs = require(base_path('configs.php'));

$db = new Database($configs['Database']);

$db->query("DELETE FROM flavor_tbl WHERE flavor_id = :id", [
  'id' => $_POST['flavor_id']
]);

header("Location: /orders/flavors");