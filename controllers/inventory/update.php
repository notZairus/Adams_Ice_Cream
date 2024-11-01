<?php 

$config = require(base_path('configs.php'));
$db = new Database($config['Database']);


//update the ingredient details on ingredient_tbl
$db->query('UPDATE ingredient_tbl SET ingredient_name = :name, ingredient_stock = :stock, ingredient_price = :price, ingredient_unit = :unit, ingredient_usage_per_4_gallons = :usage WHERE ingredient_id = :id', [
  'name' => $_POST['ingredient_name'],
  'stock'=> $_POST['ingredient_stock'],
  'price' => $_POST['ingredient_price'],
  'unit' => $_POST['ingredient_unit'],
  'usage' => $_POST['ingredient_usage_per_4_gallons'],
  'id' => $_POST['ingredient_id']
]);


header('Location: /inventory');
header('Location: /inventory');