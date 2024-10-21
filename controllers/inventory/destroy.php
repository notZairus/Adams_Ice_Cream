<?php

$config = require(base_path('configs.php'));

$db = new Database($config['Database']);

$db->query('DELETE FROM ingredient_tbl WHERE ingredient_id = :id', [
  'id' => $_POST['ingredient_id']
]);

header('Location: /inventory');
die();