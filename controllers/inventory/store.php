<?php

$config = require(base_path('configs.php'));
$db = new Database($config['Database']);

$db->query('UPDATE ingredient_tbl SET ingredient_stock = ingredient_stock + :stock WHERE ingredient_id = :id', [
  'stock' => $_POST['new_stocks'],
  'id' => $_POST['ingredient_id']
]);

header('Location: ' . $_POST['request_from']);
die();