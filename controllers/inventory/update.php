<?php 

$config = require(base_path('configs.php'));

$db = new Database($config['Database']);

$db->query('UPDATE ingredient_tbl SET
    ingredient_name = :name,
    ingredient_price = :price,
    ingredient_stock = :stock,
    ingredient_unit = :unit
  WHERE ingredient_id = :id
', [
  'name' => $_POST['ingredient_name'],
  'price' => $_POST['ingredient_price'],
  'stock' => $_POST['ingredient_stock'],
  'unit' => $_POST['ingredient_unit'],
  'id' => $_POST['ingredient_id']
]);

header('Location: /inventory');