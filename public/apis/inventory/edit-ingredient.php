<?php 

require('../requires.php');

$configs = require(base_path('configs.php'));
$db = new Database($configs['Database']);

$ingredient = json_decode(file_get_contents('php://input'), true);

$db->query('UPDATE ingredient_tbl SET ingredient_name = :name, ingredient_stock = :stock, ingredient_price = :price, ingredient_unit = :unit, ingredient_usage_per_4_gallons = :usage_per_4_gallons WHERE ingredient_id = :id', [
  'id' => $ingredient['ingredient_id'],
  'name' => $ingredient['ingredient_name'],
  'stock' => $ingredient['ingredient_stock'],
  'price' => $ingredient['ingredient_price'],
  'unit' => $ingredient['ingredient_unit'],
  'usage_per_4_gallons' => $ingredient['ingredient_usage_per_4_gallons']
]);

echo json_encode(['success' => true]);